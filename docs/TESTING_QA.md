# Testing and QA

## Automated suite

`PlatformTest` exercises real Laravel HTTP/service flows with fresh SQLite migrations: registration/verification, login/logout, inactive identity, reset/revocation, role escalation protection, customer record isolation, shopping through unpaid order creation, server-side totals, stock rollback, checkout retries, cancellation, manual receipts, lifecycle transitions, catalogue validation/archive, enquiries/consent/honeypot, manufacturing release/revoke, QR labels/exports, token API, Swagger protection, escaped publications and workspace rendering. `PublicSiteTest` preserves the institution's route/content/security baseline.

`PublicReleaseAuditTest` adds a release-oriented public-surface gate. It renders every configured institutional/division/future page plus the collection, updates and enquiry surfaces; requires one primary `h1`, non-empty description metadata, canonical/Open Graph metadata, no placeholder/executable links, and no migration placeholder copy. It also crawls rendered same-origin GET links and fails when an internal link resolves to a 4xx/5xx response, and verifies the production robots policy keeps private namespaces out of indexing.

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

Automated route/link/metadata checks do not replace visual browser QA. Confirm line wrapping, interaction states, touch targets, actual image crops, focus visibility, sticky navigation behavior, browser autofill and assistive-technology semantics on staging.

Verify real CSRF protection through the browser; HTTP feature tests normally bypass CSRF middleware. Ensure full-page/private responses are not cached. Account/API/admin screens must be excluded from indexing. Test SMTP and actual QR packaging on staging before release.

No passing test is a claim of regulatory, clinical or scientific validation.
