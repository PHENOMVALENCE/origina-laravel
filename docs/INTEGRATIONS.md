# External integrations

ORIGINA keeps payment and messaging providers behind explicit service contracts. External services are fail-closed: no provider is considered operational until its driver is enabled, its required configuration exists and the production acceptance checks are complete.

## Payment contract

`App\Contracts\Payments\PaymentGateway` exposes two responsibilities:

- `ready()` — confirms that the selected adapter has the minimum configuration needed to be used;
- `createCheckout(Order $order)` — creates a provider checkout session and returns its provider reference and checkout URL.

The default driver is `disabled`, implemented by `DisabledPaymentGateway`. It never reports readiness and never simulates payment.

### Stripe preparation

`StripePaymentGateway` prepares the server-side Stripe Checkout session boundary using Laravel's HTTP client. It is intentionally not wired into the customer checkout flow yet.

Stripe is considered ready only when all of the following are configured:

- `PAYMENTS_DRIVER=stripe`;
- `STRIPE_SECRET`;
- `STRIPE_WEBHOOK_SECRET`;
- a reviewed positive `STRIPE_MINOR_UNIT_MULTIPLIER` for the production account/currency relationship.

The explicit multiplier prevents ORIGINA from assuming how whole-TZS amounts should be translated into the provider's expected smallest currency unit. This must be confirmed against the actual merchant account before enabling online payment.

Before the Stripe adapter can become operational, a reviewed follow-up must add:

1. checkout-flow selection between the current manual workflow and Stripe;
2. signed webhook verification and idempotent payment reconciliation;
3. strict order amount/currency/reference validation;
4. successful/cancelled/expired payment states;
5. refund/cancellation reconciliation policy;
6. provider sandbox acceptance tests using the real merchant configuration;
7. production monitoring and webhook replay procedures.

Do not treat a browser return URL as proof of payment. Provider-signed webhook reconciliation is the authority for online payment confirmation.

## SMS contract

`App\Contracts\Messaging\SmsGateway` defines readiness and send operations. The only installed implementation is currently `DisabledSmsGateway`.

`SMS_DRIVER=disabled` is therefore the only supported configuration at this stage. The environment keys `SMS_FROM`, `SMS_ENDPOINT` and `SMS_TOKEN` reserve the integration boundary without assuming a provider-specific API contract.

When an SMS subscription/provider is approved, add a provider adapter with:

- normalized Tanzanian/international destination validation;
- request authentication and timeout/retry policy;
- delivery response identifiers;
- rate limiting and provider error mapping;
- message templates that avoid sensitive data;
- delivery-status handling where supported;
- automated tests with the provider transport faked;
- production credential and sender-ID acceptance checks.

Do not log full credentials or unnecessarily retain full message bodies.

## Production checks

`php artisan origina:production-check` reports the configured payment and SMS drivers without printing secrets. If Stripe is selected, its required configuration becomes part of the release gate. An unsupported non-disabled SMS driver deliberately fails the production check.

The current manual-payment workflow remains valid independently of Stripe. Online payment and SMS must not be advertised as operational until the corresponding follow-up implementation and real-provider acceptance work are complete.
