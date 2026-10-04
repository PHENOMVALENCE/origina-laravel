<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProductionCheck extends Command
{
    protected $signature = 'origina:production-check';

    protected $description = 'Check essential production configuration without printing secrets';

    public function handle(): int
    {
        $checks = [
            'Production environment' => app()->environment('production'),
            'Debug disabled' => ! config('app.debug'),
            'Application key configured' => (bool) config('app.key'),
            'HTTPS canonical URL' => str_starts_with((string) config('app.url'), 'https://'),
            'Secure session cookies' => (bool) config('session.secure'),
            'MySQL configured' => config('database.default') === 'mysql',
            'SMTP configured' => config('mail.default') === 'smtp' && (bool) config('mail.mailers.smtp.host'),
            'Built assets' => is_file(public_path('build/manifest.json')),
            'Public storage linked' => is_link(public_path('storage')),
        ];

        $paymentDriver = (string) config('integrations.payments.driver', 'disabled');
        if ($paymentDriver === 'stripe') {
            $checks['Stripe secret configured'] = filled(config('integrations.payments.stripe.secret'));
            $checks['Stripe webhook secret configured'] = filled(config('integrations.payments.stripe.webhook_secret'));
            $multiplier = config('integrations.payments.stripe.minor_unit_multiplier');
            $checks['Stripe currency multiplier confirmed'] = is_numeric($multiplier) && (int) $multiplier > 0;
        } elseif ($paymentDriver !== 'disabled') {
            $checks['Supported payment driver'] = false;
        }

        $smsDriver = (string) config('integrations.sms.driver', 'disabled');
        if ($smsDriver !== 'disabled') {
            $checks['Supported SMS driver'] = false;
        }

        try {
            DB::connection()->getPdo();
            $checks['Database reachable'] = true;
        } catch (\Throwable) {
            $checks['Database reachable'] = false;
        }

        foreach ($checks as $name => $ok) {
            $this->line(($ok ? 'PASS ' : 'FAIL ').$name);
        }

        $this->line('INFO Payment driver: '.$paymentDriver);
        $this->line('INFO SMS driver: '.$smsDriver);
        $this->warn('Also verify backups/restore, approved catalogue, shipping coverage, payment instructions, email delivery, provider webhooks where enabled and MySQL concurrency before launch.');

        return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
    }
}
