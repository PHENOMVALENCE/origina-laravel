# Testing and QA

## Automated suite

`PlatformTest` exercises real Laravel HTTP/service flows with fresh SQLite migrations: registration/verification, login/logout, inactive identity, reset/revocation, role escalation protection, customer record isolation, shopping through unpaid order creation, server-side totals, stock rollback, checkout retries, cancellation, manual receipts, lifecycle transitions, catalogue validation/archive, enquiries/consent/honeypot, manufacturing release/revoke, QR labels/exports, token API, Swagger protection, escaped publications and workspace rendering. `PublicSiteTest` preserves the institution's route/content/security baseline.

SQLite confirms domain behavior but cannot validate MySQL row locking. CI additionally runs the platform suite against MySQL. A dedicated MySQL concurrency test launches separate workers competing for one stock unit; exactly one order must succeed. This test skips when running SQLite and uses a dedicated test database, never production.

## Commands

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm ci
npm run build
composer audit
npm audit
php artisan route:cache
php artisan view:cache
```

Sandbox fallback for prohibited PHPStan worker sockets: `vendor/bin/phpstan analyse --debug --memory-limit=1G`. Do not weaken static analysis or hide errors.

## Browser review

Review institutional homepage, collection, product, bag, checkout, auth, customer overview/order/profile, admin overview/products/order/access/enquiries/batches/publications, Swagger and product verification. Use desktop ~1440, tablet ~768, mobile 375 and narrow 320px. Check horizontal overflow, image framing, heading hierarchy, readable contrast, accessible labels, keyboard focus and reduced motion. Tables intentionally scroll within their own container.

Verify real CSRF protection through the browser; HTTP feature tests normally bypass CSRF middleware. Ensure full-page/private responses are not cached. Account/API/admin screens must be excluded from indexing. Test SMTP and actual QR packaging on staging before release.

No passing test is a claim of regulatory, clinical or scientific validation.
