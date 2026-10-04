<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductionCheck extends Command
{
    protected $signature = 'origina:production-check';

    protected $description = 'Check essential production configuration without printing secrets';

    public function handle(): int
    {
        $mailFrom = strtolower((string) config('mail.from.address'));
        $paymentInstructions = trim((string) config('commerce.payment_instructions'));
        $checkoutEnabled = (bool) config('commerce.checkout_enabled');

        $checks = [
            'Production environment' => app()->environment('production'),
            'Debug disabled' => ! config('app.debug'),
            'Application key configured' => (bool) config('app.key'),
            'HTTPS canonical URL' => str_starts_with((string) config('app.url'), 'https://'),
            'Secure session cookies' => (bool) config('session.secure'),
            'Encrypted sessions' => (bool) config('session.encrypt'),
            'HTTP-only session cookies' => (bool) config('session.http_only'),
            'Safe SameSite policy' => in_array(config('session.same_site'), ['lax', 'strict'], true),
            'MySQL configured' => config('database.default') === 'mysql',
            'SMTP configured' => config('mail.default') === 'smtp' && (bool) config('mail.mailers.smtp.host'),
            'Approved mail sender configured' => $mailFrom !== '' && ! Str::endsWith($mailFrom, '@example.com'),
            'Built assets' => is_file(public_path('build/manifest.json')),
            'Public storage linked' => is_link(public_path('storage')),
            'Laravel storage writable' => is_writable(storage_path()),
            'Bootstrap cache writable' => is_writable(base_path('bootstrap/cache')),
            'Checkout commercial configuration' => ! $checkoutEnabled || (
                (int) config('commerce.shipping_fee') >= 0
                && $paymentInstructions !== ''
                && ! str_contains(strtolower($paymentInstructions), 'your_verified')
                && ! str_contains(strtolower($paymentInstructions), 'example')
            ),
        ];

        try {
            DB::connection()->getPdo();
            $checks['Database reachable'] = true;
        } catch (\Throwable) {
            $checks['Database reachable'] = false;
        }

        foreach ($checks as $name => $ok) {
            $this->line(($ok ? 'PASS ' : 'FAIL ').$name);
        }

        if ((bool) config('commerce.api_docs_enabled')) {
            $this->warn('WARN Production API documentation is enabled. Confirm this is intentional and administrator-only.');
        }

        $this->warn('HOST GATES: verify scheduler execution, backups and restore, SMTP delivery, approved catalogue and claims, shipping coverage, payment ownership, real QR scans, HTTPS headers and rollback procedure.');
        $this->warn('EXTERNAL GATES: Stripe/SMS integrations remain disabled until real credentials, provider acceptance and reconciliation/webhook tests are completed.');

        return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
    }
}
