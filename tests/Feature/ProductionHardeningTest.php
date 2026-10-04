<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\ManufacturingBatch;
use App\Models\Product;
use App\Models\User;
use App\Services\Traceability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProductionHardeningTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        $user = User::create([
            'name' => 'Security Test User',
            'email' => Str::uuid().'@example.com',
            'password' => 'StrongPassword123',
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

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
            'description' => 'Test fixture only.',
            'price' => 40000,
            'stock' => 1,
            'published' => false,
        ]);
    }

    public function test_profile_and_password_changes_are_audited_without_sensitive_values(): void
    {
        $user = $this->user();
        $user->createToken('production-hardening-test');

        $this->actingAs($user)->patch('/account/profile', [
            'name' => 'Updated Security User',
            'current_password' => 'StrongPassword123',
            'password' => 'ChangedPassword123',
            'password_confirmation' => 'ChangedPassword123',
        ])->assertSessionHas('status');

        $this->assertSame(0, $user->tokens()->count());
        $this->assertTrue(AuditLog::where('action', 'user.profile_updated')->where('subject_id', $user->id)->exists());
        $passwordLog = AuditLog::where('action', 'user.password_changed')->where('subject_id', $user->id)->firstOrFail();
        $this->assertSame(['api_tokens_revoked' => true], $passwordLog->changes);
        $this->assertStringNotContainsString('ChangedPassword123', json_encode($passwordLog->changes));
    }

    public function test_empty_manufacturing_batch_cannot_be_released(): void
    {
        $batch = ManufacturingBatch::create([
            'product_id' => $this->product()->id,
            'code' => 'EMPTY-BATCH',
            'manufactured_on' => now()->toDateString(),
            'expires_on' => now()->addYear()->toDateString(),
        ]);
        $service = app(Traceability::class);
        $service->transition($batch, 'quality_review', 'Quality review notes with sufficient detail.');

        $this->expectException(ValidationException::class);
        $service->transition($batch, 'released', 'Release notes with sufficient quality evidence.');
    }

    public function test_status_command_reports_operational_scope_and_provider_boundary(): void
    {
        $this->artisan('origina:status')
            ->expectsOutputToContain('operational platform')
            ->expectsOutputToContain('payment and SMS providers remain disabled')
            ->assertSuccessful();
    }
}
