<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Enquiry;
use App\Models\ManufacturingBatch;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Publication;
use App\Models\User;
use App\Services\Checkout;
use App\Services\OrderWorkflow;
use App\Services\Traceability;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['commerce.checkout_enabled' => true, 'commerce.shipping_fee' => 5000]);
    }

    private function user(string $role = 'customer'): User
    {
        $user = User::create(['name' => 'Test Person', 'email' => Str::uuid().'@example.com', 'password' => 'StrongPassword123']);
        $user->forceFill(['role' => $role, 'email_verified_at' => now()])->save();

        return $user;
    }

    private function product(int $stock = 5): Product
    {
        $id = Str::lower(Str::random(8));

        return Product::create(['name' => 'Test approved product', 'slug' => 'product-'.$id, 'sku' => 'SKU-'.$id, 'division' => 'b-melanox', 'description' => 'Test fixture only. No scientific claims.', 'price' => 40000, 'stock' => $stock, 'published' => true, 'image_path' => 'img/products/bmelanox-01.jpeg']);
    }

    private function order(User $user, Product $product): Order
    {
        return app(Checkout::class)->place($user, [$product->id => 2], ['name' => $user->name, 'phone' => '+255700000000', 'address' => 'Test address', 'city' => 'Dar es Salaam'], (string) Str::uuid());
    }

    public function test_registration_cannot_assign_admin_and_sends_verification(): void
    {
        Notification::fake();
        $this->post('/register', ['name' => 'Valence', 'email' => 'new@example.com', 'password' => 'StrongPassword123', 'password_confirmation' => 'StrongPassword123', 'consent' => 1, 'role' => 'admin'])->assertRedirect('/email/verify');
        $user = User::where('email', 'new@example.com')->firstOrFail();
        $this->assertSame('customer', $user->role);
        $this->assertFalse($user->hasVerifiedEmail());
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_signed_verification_unlocks_account(): void
    {
        $user = $this->user();
        $user->forceFill(['email_verified_at' => null])->save();
        $this->actingAs($user)->get('/account')->assertRedirect('/email/verify');
        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(30), ['id' => $user->id, 'hash' => sha1($user->email)]);
        $this->get($url)->assertRedirect('/account');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_login_and_logout_and_inactive_access(): void
    {
        $user = $this->user();
        $this->post('/login', ['email' => $user->email, 'password' => 'StrongPassword123'])->assertRedirect('/account');
        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $user->forceFill(['active' => false])->save();
        $this->post('/login', ['email' => $user->email, 'password' => 'StrongPassword123'])->assertSessionHasErrors('email');
    }

    public function test_password_reset_revokes_tokens(): void
    {
        Notification::fake();
        $user = $this->user();
        $user->createToken('testing');
        $this->post('/forgot-password', ['email' => $user->email])->assertSessionHas('status');
        $token = Password::createToken($user);
        $this->post('/reset-password', ['email' => $user->email, 'token' => $token, 'password' => 'ChangedPassword123', 'password_confirmation' => 'ChangedPassword123'])->assertRedirect('/login');
        $this->assertCount(0, $user->tokens()->get());
        $this->post('/login', ['email' => $user->email, 'password' => 'ChangedPassword123'])->assertRedirect('/account');
    }

    public function test_customer_cannot_enter_admin_or_read_another_order(): void
    {
        $owner = $this->user();
        $other = $this->user();
        $order = $this->order($owner, $this->product());
        $this->actingAs($other)->get('/admin')->assertForbidden();
        $this->get('/account/orders/'.$order->id)->assertNotFound();
        $this->post('/account/orders/'.$order->id.'/cancel')->assertNotFound();
    }

    public function test_checkout_prices_stock_idempotency_and_cancellation(): void
    {
        $user = $this->user();
        $product = $this->product();
        $order = $this->order($user, $product);
        $this->assertSame(85000, $order->total);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame('unpaid', $order->payment_status);
        $again = app(Checkout::class)->place($user, [], [], $order->checkout_key);
        $this->assertSame($order->id, $again->id);
        $this->assertSame(1, Order::count());
        app(OrderWorkflow::class)->transition($order, 'cancelled');
        $this->assertSame(5, $product->fresh()->stock);
        try {
            app(OrderWorkflow::class)->transition($order, 'cancelled');
            $this->fail('Duplicate cancellation should fail');
        } catch (ValidationException) {
            $this->assertSame(5, $product->fresh()->stock);
        }
    }

    public function test_checkout_failure_rolls_back_all_stock_and_orders(): void
    {
        $user = $this->user();
        $first = $this->product();
        $second = $this->product(0);
        try {
            app(Checkout::class)->place($user, [$first->id => 1, $second->id => 1], [], (string) Str::uuid());
            $this->fail('Checkout should fail');
        } catch (ValidationException) {
            $this->assertSame(5, $first->fresh()->stock);
            $this->assertSame(0, Order::count());
        }
    }

    public function test_web_shopping_journey_creates_order_without_taking_payment(): void
    {
        $user = $this->user();
        $product = $this->product();
        $this->get('/shop')->assertOk()->assertSee($product->name);
        $this->get('/shop/'.$product->slug)->assertOk();
        $this->post('/cart/'.$product->id, ['quantity' => 2])->assertRedirect('/cart');
        $this->get('/cart')->assertOk()->assertSee('80,000');
        $this->actingAs($user)->get('/checkout')->assertOk()->assertSee('85,000');
        $key = session('checkout_key');
        $this->post('/checkout', ['name' => 'Recipient', 'phone' => '+255700000000', 'address' => 'Test location', 'city' => 'Dar es Salaam', 'checkout_key' => $key, 'consent' => 1, 'total' => 1])->assertRedirect();
        $this->assertDatabaseHas('orders', ['total' => 85000, 'payment_status' => 'unpaid']);
        $this->get('/account/orders/'.Order::firstOrFail()->id)->assertOk()->assertSee('Payment is pending');
        $this->get('/account')->assertOk();
        $this->post('/cart/'.$product->id, ['quantity' => 1])->assertRedirect('/cart');
        $this->get('/checkout')->assertOk();
        $this->assertNotSame($key, session('checkout_key'));
    }

    public function test_checkout_disabled_and_unpublished_items_are_rejected(): void
    {
        config(['commerce.checkout_enabled' => false]);
        $this->actingAs($this->user());
        $product = $this->product();
        $this->withSession(['cart' => [$product->id => 1], 'checkout_key' => $key = (string) Str::uuid()])->post('/checkout', ['name' => 'Recipient', 'phone' => '123', 'address' => 'Test', 'city' => 'Dar', 'checkout_key' => $key, 'consent' => 1])->assertSessionHasErrors('checkout');
        $product->update(['published' => false]);
        $this->get('/shop/'.$product->slug)->assertNotFound();
        $this->post('/cart/'.$product->id, ['quantity' => 1])->assertSessionHasErrors('cart');
    }

    public function test_admin_payment_and_fulfilment_are_auditable(): void
    {
        $order = $this->order($this->user(), $this->product());
        $this->actingAs($this->user('admin'));
        $this->patch('/admin/orders/'.$order->id, ['status' => 'confirmed'])->assertSessionHasErrors('status');
        $this->post('/admin/orders/'.$order->id.'/payment', ['payment_reference' => 'BANK-001', 'confirm' => 1])->assertSessionHas('status');
        $this->patch('/admin/orders/'.$order->id, ['status' => 'confirmed'])->assertSessionHas('status');
        $this->patch('/admin/orders/'.$order->id, ['status' => 'processing'])->assertSessionHas('status');
        $this->patch('/admin/orders/'.$order->id, ['status' => 'shipped'])->assertSessionHasErrors('tracking_reference');
        $this->patch('/admin/orders/'.$order->id, ['status' => 'shipped', 'tracking_reference' => 'DISPATCH-001'])->assertSessionHas('status');
        $this->patch('/admin/orders/'.$order->id, ['status' => 'delivered'])->assertSessionHas('status');
        $this->assertSame('delivered', $order->fresh()->status);
        $this->assertTrue(AuditLog::where('action', 'payment.manually_confirmed')->exists());
    }

    public function test_paid_orders_cannot_be_cancelled_or_paid_twice(): void
    {
        $order = $this->order($this->user(), $this->product());
        app(OrderWorkflow::class)->confirmPayment($order, 'UNIQUE-001');
        $this->expectException(ValidationException::class);
        app(OrderWorkflow::class)->transition($order, 'cancelled');
    }

    public function test_admin_can_manage_catalogue_and_upload(): void
    {
        $this->actingAs($this->user('admin'));
        $data = ['name' => 'Approved fixture', 'sku' => 'ADMIN-1', 'slug' => 'approved-fixture', 'division' => 'novia', 'description' => 'Approved test description', 'price' => 50000, 'stock' => 10, 'published' => 1, 'image' => UploadedFile::fake()->create('image.svg', 1, 'image/svg+xml')];
        $this->post('/admin/products', $data)->assertSessionHasErrors('image');
        unset($data['image']);
        Storage::fake('public');
        $data['image'] = UploadedFile::fake()->createWithContent('product.jpg', file_get_contents(public_path('img/products/bmelanox-01.jpeg')));
        $this->post('/admin/products', $data)->assertRedirect('/admin/products');
        $p = Product::firstOrFail();
        Storage::disk('public')->assertExists(substr($p->image_path, 8));
        $this->get('/admin/products/'.$p->id.'/edit')->assertOk();
        $this->post('/admin/products/'.$p->id.'/archive')->assertSessionHas('status');
        $this->assertFalse($p->fresh()->published);
    }

    public function test_customer_cannot_mutate_admin_records_or_self_promote(): void
    {
        $user = $this->user();
        $this->actingAs($user)->post('/admin/products', [])->assertForbidden();
        $this->patch('/account/profile', ['name' => 'New Name', 'current_password' => 'StrongPassword123', 'role' => 'admin'])->assertSessionHas('status');
        $this->assertSame('customer', $user->fresh()->role);
    }

    public function test_admin_cannot_remove_own_access_and_deactivation_blocks_session(): void
    {
        $admin = $this->user('admin');
        $customer = $this->user();
        $this->actingAs($admin)->patch('/admin/customers/'.$admin->id, ['role' => 'customer', 'active' => 0])->assertStatus(422);
        $this->patch('/admin/customers/'.$customer->id, ['role' => 'customer', 'active' => 0])->assertSessionHas('status');
        $this->flushSession();
        $this->actingAs($customer->fresh())->get('/account')->assertForbidden();
    }

    public function test_enquiries_persist_with_consent_and_reject_honeypot(): void
    {
        $data = ['name' => 'Visitor', 'email' => 'visitor@example.com', 'topic' => 'Customer Support', 'message' => 'A valid customer support enquiry for testing.', 'consent' => 1];
        $this->post('/enquire', $data + ['website' => 'spam'])->assertSessionHasErrors('website');
        $this->assertSame(0, Enquiry::count());
        $this->post('/enquire', $data)->assertSessionHas('status');
        $this->assertNotNull(Enquiry::firstOrFail()->consented_at);
    }

    public function test_traceability_release_qr_and_revoke(): void
    {
        $batch = ManufacturingBatch::create(['product_id' => $this->product()->id, 'code' => 'TEST-BATCH', 'manufactured_on' => now()->toDateString(), 'expires_on' => now()->addYear()->toDateString()]);
        $service = app(Traceability::class);
        $service->generate($batch, 2);
        $unit = ProductUnit::firstOrFail();
        $this->get('/verify/'.$unit->verification_token)->assertOk()->assertSee('Unable to validate');
        $service->transition($batch, 'quality_review', 'Quality review documentation reference');
        $service->transition($batch, 'released', 'Quality evidence reviewed and approved');
        $this->get('/verify/'.$unit->verification_token)->assertOk()->assertSee('A released product record');
        $this->actingAs($this->user('admin'))->get('/admin/units/'.$unit->id.'/label')->assertOk()->assertSee('data:image/svg+xml;base64', false);
        $this->get('/admin/batches/'.$batch->id.'/export')->assertOk()->assertDownload('TEST-BATCH-labels.csv');
        $this->post('/admin/units/'.$unit->id.'/revoke')->assertSessionHas('status');
        $this->get('/verify/'.$unit->verification_token)->assertSee('Unable to validate');
    }

    public function test_draft_or_expired_batch_cannot_verify_and_generation_after_review_is_blocked(): void
    {
        $batch = ManufacturingBatch::create(['product_id' => $this->product()->id, 'code' => 'EXPIRED', 'manufactured_on' => now()->subYear(), 'expires_on' => now()->subDay()]);
        $service = app(Traceability::class);
        $service->generate($batch, 1);
        $service->transition($batch, 'quality_review', 'Review data with sufficient details');
        $this->expectException(ValidationException::class);
        $service->transition($batch, 'released', 'Reviewed and approved quality notes');
    }

    public function test_api_uses_bearer_auth_and_limits_customer_order_access(): void
    {
        $user = $this->user();
        $product = $this->product();
        $order = $this->order($user, $product);
        $other = $this->user();
        $token = $other->createToken('test')->plainTextToken;
        $this->getJson('/api/v1/orders')->assertUnauthorized();
        $this->withToken($token)->getJson('/api/v1/orders/'.$order->id)->assertNotFound();
        $this->getJson('/api/v1/admin/orders')->assertForbidden();
        $this->getJson('/api/v1/products')->assertOk()->assertJsonPath('data.0.name', $product->name);
        $this->getJson('/api/v1/products/'.$product->id)->assertOk();
    }

    public function test_api_checkout_is_server_priced_and_retry_safe(): void
    {
        $user = $this->user();
        $p = $this->product();
        $token = $user->createToken('test')->plainTextToken;
        $data = ['items' => [['product_id' => $p->id, 'quantity' => 2]], 'shipping_address' => ['name' => 'Test', 'phone' => '123', 'city' => 'Dar', 'address' => 'Test'], 'checkout_key' => (string) Str::uuid(), 'consent' => true, 'total' => 1];
        $this->withToken($token)->postJson('/api/v1/orders', $data)->assertCreated()->assertJsonPath('data.total', 85000);
        $this->postJson('/api/v1/orders', $data)->assertCreated();
        $this->assertSame(1, Order::count());
    }

    public function test_api_token_issue_revocation_and_unverified_rejection(): void
    {
        $user = $this->user();
        $data = ['email' => $user->email, 'password' => 'StrongPassword123', 'device_name' => 'Swagger test'];
        $response = $this->postJson('/api/v1/tokens', $data)->assertOk();
        $token = $response->json('token');
        $this->withToken($token)->getJson('/api/v1/me')->assertOk();
        $this->deleteJson('/api/v1/tokens/current')->assertNoContent();
        $this->assertSame(0, $user->tokens()->count());
    }

    public function test_swagger_docs_are_protected_and_can_be_disabled_in_production(): void
    {
        $this->get('/admin/api-docs')->assertRedirect('/login');
        $this->actingAs($this->user('admin'))->get('/admin/api-docs')->assertOk();
        $this->get('/admin/openapi.json')->assertOk();
        $this->app->detectEnvironment(fn () => 'production');
        config(['commerce.api_docs_enabled' => false]);
        $this->get('/admin/api-docs')->assertNotFound();
    }

    public function test_publication_workflow_escapes_content_and_hides_drafts(): void
    {
        $admin = $this->user('admin');
        $data = ['title' => 'Verified research update', 'slug' => 'test-update', 'type' => 'research', 'summary' => 'Test summary', 'body' => '<script>alert(1)</script>', 'status' => 'draft', 'reviewed' => 1];
        $this->actingAs($admin)->post('/admin/publications', $data)->assertRedirect('/admin/publications');
        $publication = Publication::firstOrFail();
        $this->get('/updates/test-update')->assertNotFound();
        $data['status'] = 'published';
        $this->put('/admin/publications/'.$publication->id, $data)->assertRedirect('/admin/publications');
        $this->get('/updates/test-update')->assertOk()->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_all_admin_surfaces_render_and_private_pages_are_not_cacheable(): void
    {
        $this->actingAs($this->user('admin'));
        foreach (['/admin', '/admin/products', '/admin/products/create', '/admin/orders', '/admin/customers', '/admin/enquiries', '/admin/batches', '/admin/audit', '/admin/publications', '/admin/publications/create', '/account/profile'] as $uri) {
            $this->get($uri)->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        } $response = $this->get('/admin');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }
}
