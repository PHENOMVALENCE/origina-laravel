# ORIGINA™ Laravel platform

ORIGINA is a science-led institution headquartered in Dar es Salaam. Biology First™ governs the public experience; commerce and operations sit beneath that institutional layer.

## Stack

Laravel 12 / PHP 8.2, Blade, Vite, MySQL in production, SQLite for local development, Sanctum bearer API, locally bundled Swagger UI and printable serialized QR labels. The supported application runtime is PHP `>=8.2.12 <8.3`, matching the maintainer's local PHP 8.2 line. Production should use the newest available PHP 8.2 security patch rather than staying on an old patch release. Source Serif 4 + Source Sans 3, semantic institution/division tokens, server-rendered screens and progressive enhancement.

## Local setup

Confirm the runtime first:

```bash
php -v
composer runtime:check
```

Then install and run the application:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm ci
npm run build
php artisan origina:admin
php artisan serve
```

If `composer.json` changed its PHP/platform constraints, refresh lock metadata once with `composer update --lock` and commit the resulting `composer.lock` before release. Do not use `--ignore-platform-reqs` to make an incompatible environment appear supported.

No default credentials or fabricated saleable products. Add approved catalogue records through `/admin/products`. For local checkout testing set `COMMERCE_CHECKOUT_ENABLED=true`, a deliberate `COMMERCE_SHIPPING_FEE` and clear `COMMERCE_PAYMENT_INSTRUCTIONS` in `.env`. Do not copy test credentials into production.

Local mail defaults to the Laravel log mailer. Configure real SMTP to deliver verification/reset/order messages. The administrator CLI creates a verified account interactively; customer registration requires email verification. Institutional pages remain public.

## Surfaces

| Route | Purpose |
|---|---|
| `/`, `/science`, `/labs`, `/divisions`, `/founder`, `/future` | Institution and scientific information |
| `/shop`, `/shop/{slug}`, `/cart`, `/checkout` | Product discovery through unpaid order placement |
| `/account`, `/account/orders`, `/account/profile` | Customer dashboard, history, tracking and security |
| `/admin` | Operational overview |
| `/admin/products`, `/admin/orders`, `/admin/customers` | Catalogue, fulfilment and access management |
| `/admin/enquiries`, `/admin/publications` | Incoming conversations and approved publications |
| `/admin/batches`, `/admin/audit` | Manufacturing, units, labels and audit history |
| `/admin/api-docs` | Protected Swagger testing interface |
| `/api/v1` | JSON API; see OpenAPI contract |
| `/enquire`, `/verify/{token}`, `/updates` | Enquiries, serialized product records and publications |

## Quality gates

```bash
composer runtime:check
composer validate --strict
composer check-platform-reqs
composer lint:test
composer analyse
composer test
npm ci
npm run build
composer audit
npm audit
```

If a restricted local sandbox prevents PHPStan spawning workers, `vendor/bin/phpstan analyse --debug --memory-limit=1G` runs the same analysis serially. CI uses the normal command.

## Documentation

Start with [platform architecture](docs/ARCHITECTURE.md), [shopping journey](docs/COMMERCE.md), [administrator handbook](docs/ADMIN_HANDBOOK.md), [API testing](docs/API_TESTING.md), [traceability](docs/TRACEABILITY.md), [deployment](docs/DEPLOYMENT.md) and [production checklist](docs/PRODUCTION_CHECKLIST.md).

Frontend references remain in `DESIGN.md`, `docs/DESIGN_SYSTEM.md`, `docs/FRONTEND_ARCHITECTURE.md`, `docs/CONTENT_GOVERNANCE.md` and `docs/FRONTEND_PARITY.md`. Operational scope is authorized in [ADR 0002](docs/adr/0002-operational-platform.md).

## Release boundaries

Checkout creates unpaid orders and reserves inventory. Administrators record actual reconciled receipts; the application does not yet connect to an online payment gateway or automate refunds. Refunds must be reconciled before a future refund workflow is enabled. Shipping uses one configured TZS fee for the supported Tanzanian delivery area. No tax engine, carrier integration, variant/MOQ system or ERP is claimed.

A complete verified-code match cannot independently establish authenticity of physical contents. Manufacturing is batch/serialization/QC release management, not a certified manufacturing execution system.

All contribution ownership remains with Valence Mwigani. Work integrates through `masterchanges`; open a PR and do not auto-merge.
