<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductionAcceptanceTest extends TestCase
{
    public function test_production_check_rejects_unsafe_session_and_mail_configuration(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config([
            'app.debug' => false,
            'app.key' => 'base64:'.base64_encode(str_repeat('a', 32)),
            'app.url' => 'https://origina.example.test',
            'session.secure' => false,
            'session.encrypt' => false,
            'session.http_only' => true,
            'session.same_site' => 'lax',
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.example.test',
            'mail.from.address' => 'hello@example.com',
            'commerce.checkout_enabled' => false,
        ]);

        $exit = Artisan::call('origina:production-check');
        $output = Artisan::output();

        $this->assertSame(1, $exit);
        $this->assertStringContainsString('FAIL Secure session cookies', $output);
        $this->assertStringContainsString('FAIL Encrypted sessions', $output);
        $this->assertStringContainsString('FAIL Approved mail sender configured', $output);
        $this->assertStringContainsString('HOST GATES:', $output);
        $this->assertStringContainsString('EXTERNAL GATES:', $output);
        $this->assertStringNotContainsString('base64:', $output);
    }

    public function test_production_check_rejects_placeholder_checkout_instructions_when_checkout_is_enabled(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');
        config([
            'app.debug' => false,
            'app.key' => 'base64:'.base64_encode(str_repeat('b', 32)),
            'app.url' => 'https://origina.example.test',
            'session.secure' => true,
            'session.encrypt' => true,
            'session.http_only' => true,
            'session.same_site' => 'lax',
            'commerce.checkout_enabled' => true,
            'commerce.shipping_fee' => 5000,
            'commerce.payment_instructions' => 'Example payment instructions',
        ]);

        Artisan::call('origina:production-check');

        $this->assertStringContainsString('FAIL Checkout commercial configuration', Artisan::output());
    }
}
