# Testing and QA

## Automated suite

`PlatformTest` exercises real Laravel HTTP/service flows with fresh SQLite migrations: registration/verification, login/logout, inactive identity, reset/revocation, role escalation protection, customer record isolation, shopping through unpaid order creation, server-side totals, stock rollback, checkout retries, cancellation, manual receipts, lifecycle transitions, catalogue validation/archive, enquiries/consent/honeypot, manufacturing release/revoke, QR labels/exports, token API, Swagger protection, escaped publications and workspace rendering. `PublicSiteTest` preserves the institution's route/content/security baseline. `RuntimeCompatibilityTest` prevents accidental drift away from the PHP 8.2 application line.

SQLite confirms domain behavior but cannot validate MySQL row locking. CI additionally runs the platform suite against MySQL. A dedicated MySQL concurrency test launches separate workers competing for one stock unit; exactly one order must succeed. This test skips when running SQLite and uses a dedicated test database, never production.

CI runs PHP and MySQL jobs on PHP 8.2. The project minimum is PHP 8.2.12; production should use the newest available 8.2 security patch. PHP 8.3+ syntax or APIs must not enter the codebase while this baseline is active.

## Commands

```bash
php -v
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
php artisan route:cache
php artisan view:cache
```

Never use `--ignore-platform-reqs` as a compatibility workaround. If the PHP/platform requirement changes, refresh the lock metadata with `composer update --lock`, then restore strict lock validation before release.

Sandbox fallback for prohibited PHPStan worker sockets: `vendor/bin/phpstan analyse --debug --memory-limit=1G`. Do not weaken static analysis or hide errors.

## Browser review

Review institutional homepage, collection, product, bag, checkout, auth, customer overview/order/profile, admin overview/products/order/access/enquiries/batches/publications, Swagger and product verification. Use desktop ~1440, tablet ~768, mobile 375 and narrow 320px. Check horizontal overflow, image framing, heading hierarchy, readable contrast, accessible labels, keyboard focus and reduced motion. Tables intentionally scroll within their own container.

Verify real CSRF protection through the browser; HTTP feature tests normally bypass CSRF middleware. Ensure full-page/private responses are not cached. Account/API/admin screens must be excluded from indexing. Test SMTP and actual QR packaging on staging before release.

No passing test is a claim of regulatory, clinical or scientific validation.
