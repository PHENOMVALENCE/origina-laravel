<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Checkout;
use App\Services\OrderWorkflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderLifecycleIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['commerce.checkout_enabled' => true, 'commerce.shipping_fee' => 0]);
    }

    private function order(): Order
    {
        $user = User::create([
            'name' => 'Lifecycle Customer',
            'email' => Str::uuid().'@example.com',
            'password' => 'StrongPassword123',
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $id = Str::lower(Str::random(8));
        $product = Product::create([
            'name' => 'Lifecycle product',
            'slug' => 'lifecycle-'.$id,
            'sku' => 'LIFE-'.$id,
            'division' => 'b-melanox',
            'description' => 'Test fixture only.',
            'price' => 10000,
            'stock' => 2,
            'published' => true,
        ]);

        return app(Checkout::class)->place($user, [$product->id => 1], [
            'name' => $user->name,
            'phone' => '+255700000000',
            'address' => 'Test address',
            'city' => 'Dar es Salaam',
        ], (string) Str::uuid());
    }

    public function test_payment_reference_is_trimmed_before_persistence(): void
    {
        $order = $this->order();

        app(OrderWorkflow::class)->confirmPayment($order, '  BANK-REF-001  ');

        $this->assertSame('BANK-REF-001', $order->fresh()->payment_reference);
    }

    public function test_blank_payment_reference_is_rejected_at_the_domain_service_boundary(): void
    {
        $this->expectException(ValidationException::class);

        app(OrderWorkflow::class)->confirmPayment($this->order(), '   ');
    }

    public function test_shipping_requires_a_non_blank_tracking_reference_even_for_direct_service_calls(): void
    {
        $order = $this->order();
        $workflow = app(OrderWorkflow::class);
        $workflow->confirmPayment($order, 'PAY-001');
        $workflow->transition($order, 'confirmed');
        $workflow->transition($order, 'processing');

        try {
            $workflow->transition($order, 'shipped', '   ');
            $this->fail('Blank tracking references must not permit shipment.');
        } catch (ValidationException) {
            $this->assertSame('processing', $order->fresh()->status);
        }
    }

    public function test_tracking_reference_is_trimmed_before_persistence(): void
    {
        $order = $this->order();
        $workflow = app(OrderWorkflow::class);
        $workflow->confirmPayment($order, 'PAY-002');
        $workflow->transition($order, 'confirmed');
        $workflow->transition($order, 'processing');
        $workflow->transition($order, 'shipped', '  DISPATCH-002  ');

        $this->assertSame('DISPATCH-002', $order->fresh()->tracking_reference);
    }

    public function test_domain_service_rejects_overlong_operational_references(): void
    {
        $order = $this->order();

        try {
            app(OrderWorkflow::class)->confirmPayment($order, str_repeat('A', 151));
            $this->fail('Overlong payment references must fail.');
        } catch (ValidationException) {
            $this->assertSame('unpaid', $order->fresh()->payment_status);
        }
    }
}
