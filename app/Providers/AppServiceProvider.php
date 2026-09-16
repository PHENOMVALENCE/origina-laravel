<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind project services here when backend domains are introduced.
    }

    public function boot(): void
    {
        // Keep global boot logic minimal and explicit.
    }
}
