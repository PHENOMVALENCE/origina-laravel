<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('origina:status', function (): void {
    $this->info('ORIGINA Laravel foundation: frontend-only phase.');
})->purpose('Show the current ORIGINA implementation phase');
