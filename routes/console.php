<?php

use App\Models\VerificationScan;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('origina:status', function (): void {
    $this->info('ORIGINA Laravel foundation: frontend-only phase.');
})->purpose('Show the current ORIGINA implementation phase');

Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::call(fn () => VerificationScan::where('created_at', '<', now()->subDays(90))->delete())->daily()->name('prune-verification-scans')->withoutOverlapping();
