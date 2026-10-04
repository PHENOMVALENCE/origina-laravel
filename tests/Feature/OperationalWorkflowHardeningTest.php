<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Enquiry;
use App\Models\ManufacturingBatch;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class OperationalWorkflowHardeningTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role = 'customer'): User
    {
        $user = User::create([
            'name' => 'Test Person',
            'email' => Str::uuid().'@example.com',
            'password' => 'StrongPassword123',
        ]);
        $user->forceFill(['role' => $role, 'email_verified_at' => now()])->save();

        return $user;
    }

    private function product(): Product
    {
        $id = Str::lower(Str::random(8));

        return Product::create([
            'name' => 'Traceability fixture',
            'slug' => 'traceability-'.$id,
            'sku' => 'TRACE-'.$id,
            'division' => 'b-melanox',
            'description' => 'Fixture with no scientific claims.',
            'price' => 40000,
            'stock' => 5,
            'published' => true,
        ]);
    }

    public function test_enquiry_input_is_normalized_and_creation_is_audited_without_message_content(): void
    {
        $this->post('/enquire', [
            'name' => '  Visitor Name  ',
            'email' => '  VISITOR@EXAMPLE.COM ',
            'topic' => 'Customer Support',
            'message' => '  This is a sufficiently long customer support enquiry.  ',
            'consent' => 1,
        ])->assertSessionHas('status');

        $enquiry = Enquiry::firstOrFail();
        $this->assertSame('Visitor Name', $enquiry->name);
        $this->assertSame('visitor@example.com', $enquiry->email);
        $this->assertSame('This is a sufficiently long customer support enquiry.', $enquiry->message);

        $audit = AuditLog::where('action', 'enquiry.received')->firstOrFail();
        $this->assertSame('Customer Support', $audit->changes['topic']);
        $this->assertArrayNotHasKey('message', $audit->changes);
        $this->assertArrayNotHasKey('email', $audit->changes);
    }

    public function test_publication_publish_timestamp_is_stable_during_published_edits_and_status_change_is_audited(): void
    {
        $admin = $this->user('admin');
        $this->actingAs($admin);

        $data = [
            'title' => 'Research update',
            'slug' => 'research-update',
            'type' => 'research',
            'summary' => 'A reviewed publication summary.',
            'body' => 'A reviewed publication body.',
            'status' => 'published',
            'reviewed' => 1,
        ];

        $this->post('/admin/publications', $data)->assertRedirect('/admin/publications');
        $publication = Publication::firstOrFail();
        $publishedAt = $publication->published_at;

        $this->travel(10)->minutes();
        $data['title'] = 'Research update revised';
        $this->put('/admin/publications/'.$publication->id, $data)->assertRedirect('/admin/publications');

        $publication->refresh();
        $this->assertTrue($publication->published_at->equalTo($publishedAt));

        $audit = AuditLog::where('action', 'publication.saved')->latest('id')->firstOrFail();
        $this->assertSame('published', $audit->changes['from_status']);
        $this->assertSame('published', $audit->changes['to_status']);
        $this->assertSame('research', $audit->changes['type']);
    }

    public function test_revoked_serialized_units_cannot_be_reprinted_or_exported(): void
    {
        $admin = $this->user('admin');
        $product = $this->product();
        $batch = ManufacturingBatch::create([
            'product_id' => $product->id,
            'code' => 'TRACE-BATCH-01',
            'manufactured_on' => now()->toDateString(),
            'expires_on' => now()->addYear()->toDateString(),
        ]);
        $unit = ProductUnit::create([
            'manufacturing_batch_id' => $batch->id,
            'serial' => 'TRACE-BATCH-01-UNIT-1',
            'verification_token' => bin2hex(random_bytes(32)),
            'status' => 'created',
        ]);

        $this->actingAs($admin)->post('/admin/units/'.$unit->id.'/revoke')->assertSessionHas('status');
        $this->get('/admin/units/'.$unit->id.'/label')->assertSessionHasErrors('unit');
        $this->get('/admin/batches/'.$batch->id.'/export')->assertSessionHasErrors('batch');

        $this->post('/admin/units/'.$unit->id.'/revoke')->assertSessionHasErrors('unit');
        $this->assertSame(1, AuditLog::where('action', 'unit.revoked')->count());
    }
}
