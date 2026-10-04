<?php

namespace Tests\Feature;

use App\Contracts\Messaging\SmsGateway;
use App\Contracts\Payments\PaymentGateway;
use App\Services\Messaging\DisabledSmsGateway;
use App\Services\Payments\DisabledPaymentGateway;
use App\Services\Payments\StripePaymentGateway;
use Tests\TestCase;

class IntegrationConfigurationTest extends TestCase
{
    public function test_external_integrations_are_disabled_by_default(): void
    {
        config()->set('integrations.payments.driver', 'disabled');
        config()->set('integrations.sms.driver', 'disabled');

        $this->assertInstanceOf(DisabledPaymentGateway::class, app(PaymentGateway::class));
        $this->assertInstanceOf(DisabledSmsGateway::class, app(SmsGateway::class));
        $this->assertFalse(app(PaymentGateway::class)->ready());
        $this->assertFalse(app(SmsGateway::class)->ready());
    }

    public function test_stripe_is_not_ready_without_all_required_configuration(): void
    {
        config()->set('integrations.payments.driver', 'stripe');
        config()->set('integrations.payments.stripe.secret', 'test-secret');
        config()->set('integrations.payments.stripe.webhook_secret', null);
        config()->set('integrations.payments.stripe.minor_unit_multiplier', null);

        $gateway = app(PaymentGateway::class);

        $this->assertInstanceOf(StripePaymentGateway::class, $gateway);
        $this->assertFalse($gateway->ready());
    }

    public function test_stripe_requires_explicit_currency_multiplier_before_becoming_ready(): void
    {
        config()->set('integrations.payments.driver', 'stripe');
        config()->set('integrations.payments.stripe.secret', 'test-secret');
        config()->set('integrations.payments.stripe.webhook_secret', 'test-webhook-secret');
        config()->set('integrations.payments.stripe.minor_unit_multiplier', 100);

        $gateway = app(PaymentGateway::class);

        $this->assertInstanceOf(StripePaymentGateway::class, $gateway);
        $this->assertTrue($gateway->ready());
    }
}
