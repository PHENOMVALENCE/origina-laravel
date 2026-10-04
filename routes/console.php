<?php

use App\Models\VerificationScan;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('origina:status', function (): void {
    $this->info('ORIGINA Laravel: operational platform with institutional frontend, accounts, commerce, administration, API and traceability.');
    $this->line('External payment and SMS providers remain disabled until explicitly configured and accepted for production.');
})->purpose('Show the current ORIGINA implementation phase');

Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::call(fn () => VerificationScan::where('created_at', '<', now()->subDays(90))->delete())->daily()->name('prune-verification-scans')->withoutOverlapping();
