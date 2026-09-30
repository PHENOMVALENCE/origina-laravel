<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::defaultView('components.pagination');
        Paginator::defaultSimpleView('components.pagination');
        RateLimiter::for('identity', fn (Request $request) => [Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()), Limit::perMinute(20)->by($request->ip())]);
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by(Auth::id() ?? $request->ip()));
    }
}
