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
        $checks = ['Production environment' => app()->environment('production'), 'Debug disabled' => ! config('app.debug'), 'Application key configured' => (bool) config('app.key'), 'HTTPS canonical URL' => str_starts_with((string) config('app.url'), 'https://'), 'Secure session cookies' => (bool) config('session.secure'), 'MySQL configured' => config('database.default') === 'mysql', 'SMTP configured' => config('mail.default') === 'smtp' && (bool) config('mail.mailers.smtp.host'), 'Built assets' => is_file(public_path('build/manifest.json')), 'Public storage linked' => is_link(public_path('storage'))];
        try {
            DB::connection()->getPdo();
            $checks['Database reachable'] = true;
        } catch (\Throwable) {
            $checks['Database reachable'] = false;
        }
        foreach ($checks as $name => $ok) {
            $this->line(($ok ? 'PASS ' : 'FAIL ').$name);
        }
        $this->warn('Also verify backups/restore, approved catalogue, shipping coverage, payment instructions, email delivery and MySQL concurrency before launch.');

        return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
    }
}
