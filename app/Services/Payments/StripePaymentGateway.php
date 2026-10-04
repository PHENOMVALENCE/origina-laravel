<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentGateway;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class StripePaymentGateway implements PaymentGateway
{
    public function ready(): bool
    {
        $multiplier = config('integrations.payments.stripe.minor_unit_multiplier');

        return filled(config('integrations.payments.stripe.secret'))
            && filled(config('integrations.payments.stripe.webhook_secret'))
            && is_numeric($multiplier)
            && (int) $multiplier > 0;
    }

    public function createCheckout(Order $order): array
    {
        if (! $this->ready()) {
            throw new RuntimeException('Stripe is not fully configured.');
        }

        $multiplier = (int) config('integrations.payments.stripe.minor_unit_multiplier');
        $amount = $order->total * $multiplier;

        $response = Http::asForm()
            ->withToken((string) config('integrations.payments.stripe.secret'))
            ->acceptJson()
            ->timeout(15)
            ->post(rtrim((string) config('integrations.payments.stripe.api_base'), '/').'/v1/checkout/sessions', [
                'mode' => 'payment',
                'client_reference_id' => $order->number,
                'success_url' => route('account.orders.show', $order).'?payment=return',
                'cancel_url' => route('account.orders.show', $order).'?payment=cancelled',
                'metadata[order_id]' => (string) $order->id,
                'metadata[order_number]' => $order->number,
                'payment_intent_data[metadata][order_id]' => (string) $order->id,
                'payment_intent_data[metadata][order_number]' => $order->number,
                'line_items[0][quantity]' => 1,
                'line_items[0][price_data][currency]' => strtolower($order->currency),
                'line_items[0][price_data][unit_amount]' => $amount,
                'line_items[0][price_data][product_data][name]' => 'ORIGINA order '.$order->number,
            ]);

        if ($response->failed()) {
            report(new RuntimeException('Stripe checkout session creation failed with HTTP '.$response->status().'.'));
            throw new RuntimeException('Unable to start online payment.');
        }

        $reference = (string) $response->json('id');
        $checkoutUrl = (string) $response->json('url');

        if ($reference === '' || $checkoutUrl === '') {
            throw new RuntimeException('Stripe returned an incomplete checkout session.');
        }

        return [
            'provider' => 'stripe',
            'reference' => $reference,
            'checkout_url' => $checkoutUrl,
        ];
    }
}
