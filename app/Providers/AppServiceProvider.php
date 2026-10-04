<?php

namespace App\Providers;

use App\Contracts\Messaging\SmsGateway;
use App\Contracts\Payments\PaymentGateway;
use App\Services\Messaging\DisabledSmsGateway;
use App\Services\Payments\DisabledPaymentGateway;
use App\Services\Payments\StripePaymentGateway;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use LogicException;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGateway::class, function (): PaymentGateway {
            return match ((string) config('integrations.payments.driver', 'disabled')) {
                'disabled' => new DisabledPaymentGateway,
                'stripe' => new StripePaymentGateway,
                default => throw new LogicException('Unsupported payment driver configured.'),
            };
        });

        $this->app->bind(SmsGateway::class, function (): SmsGateway {
            $driver = (string) config('integrations.sms.driver', 'disabled');
            if ($driver !== 'disabled') {
                throw new LogicException('The configured SMS provider adapter has not been installed yet.');
            }

            return new DisabledSmsGateway;
        });
    }

    public function boot(): void
    {
        Paginator::defaultView('components.pagination');
        Paginator::defaultSimpleView('components.pagination');
        RateLimiter::for('identity', fn (Request $request) => [Limit::perMinute(5)->by(strtolower((string) $request->input('email')).'|'.$request->ip()), Limit::perMinute(20)->by($request->ip())]);
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by(Auth::id() ?? $request->ip()));
    }
}
