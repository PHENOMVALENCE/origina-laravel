# Production deployment

## Host and runtime

Use the PHP 8.2 branch with Laravel extensions, MySQL 8+ with InnoDB, HTTPS and SMTP. ORIGINA requires PHP `>=8.2.12 <8.3` to match the maintained local/runtime baseline. For production, use the newest available PHP 8.2 security patch; do not deliberately deploy an old 8.2 patch merely because local development began on 8.2.12. The web document root must be `public/`. Never serve the repository root. Deny dotfiles, `.env`, source/VCS/storage internals and executable uploads. Do not use `artisan serve` in production.

Before installing dependencies on a host, verify:

```bash
php -v
composer runtime:check
```

Do not use `--ignore-platform-reqs`. A host that cannot provide the supported PHP 8.2 runtime is not an accepted ORIGINA production host.

For Hostinger: select PHP 8.2 using the newest patch offered by the host, create a MySQL database/user, set the domain document root to the application `public` directory, configure environment over SSH, build frontend assets locally or in CI when Node is unavailable, and upload the complete fingerprinted `public/build` directory alongside the matching code. Shared hosting must support symlinks (`storage:link`), writable Laravel runtime directories and a minute-level cron. If it cannot point the document root correctly, use a suitable subdomain/application layout rather than exposing `.env`.

## Environment

```dotenv
APP_NAME=ORIGINA
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_APPROVED_DOMAIN
APP_KEY=GENERATE_ON_HOST
DB_CONNECTION=mysql
DB_HOST=YOUR_DATABASE_HOST
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USER
DB_PASSWORD=SET_SECURELY
SESSION_DRIVER=file
SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true
MAIL_MAILER=smtp
MAIL_HOST=YOUR_SMTP_HOST
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=SET_SECURELY
MAIL_FROM_ADDRESS=YOUR_APPROVED_SENDER
MAIL_FROM_NAME=ORIGINA
COMMERCE_CHECKOUT_ENABLED=false
COMMERCE_SHIPPING_FEE=YOUR_APPROVED_WHOLE_TZS_FEE
COMMERCE_PAYMENT_INSTRUCTIONS="YOUR_VERIFIED_PAYMENT_INSTRUCTIONS"
API_DOCS_ENABLED=false
```

Values above are instructions/placeholders, not credentials to copy verbatim. Generate the key once and preserve it during releases; do not rotate it casually. Set production secrets on the host, never in Git. Single-host sessions/file cache are the baseline; a multi-node release needs a shared cache/session design first. Configure only actual trusted reverse-proxy hosts if terminating TLS upstream; do not trust arbitrary forwarded headers.

## Build and release

The dependency lock must be generated against the PHP 8.2 platform baseline. After changing PHP constraints, run `composer update --lock` locally and commit `composer.lock` before cutting a release.

```bash
php -v
composer runtime:check
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
composer check-platform-reqs --no-dev
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan origina:production-check
```

Run migrations only after a verified database backup and staging rehearsal. Never run `migrate:fresh` in production. Vite built assets and application code must be from the same commit. Grant write access only to `storage` and `bootstrap/cache`; preserve uploaded media across releases. Create the first administrator with `php artisan origina:admin` through a trusted terminal.

## Scheduler

Install cron (adjust PHP binary and actual app path):

```cron
* * * * * cd /ABSOLUTE/APP/PATH && php artisan schedule:run >> /dev/null 2>&1
```

This prunes expired API tokens and verification scans older than 90 days. Monitor scheduler operation. Order mail uses synchronous native notifications; failed order notifications are logged and do not undo orders. There is no durable mail retry queue. Monitor errors and manually follow up if receipt email fails.

## Commercial activation

Keep checkout disabled until real products, inventory, claims, final consumer prices, supported delivery area, approved fee/payment instructions and terms are checked. Verify account registration, SMTP verification/password reset, order mail, ordering, receipt confirmation, dispatch, cancellation and physical QR scans on staging. Enable checkout only after those gates are met.

The application records unpaid orders and manually reconciled payment receipts. It does not collect online card/mobile-money payments or perform refunds. A future payment provider needs verified merchant keys, callback validation, amount/currency reconciliation, idempotent event handling and explicit refund rules.

## Observability, backup and rollback

Monitor `/up`, app errors, SMTP failures, failed logins, abnormal API/verification traffic and pending unpaid stock reservations. Do not log passwords/tokens/complete payment credentials. `/up` proves application availability, not a full business transaction.

Back up MySQL and uploaded media securely on a defined schedule; document retention, encryption, owner and restore procedure. Rehearse restore to an isolated host. Keep a known-good release and matching built assets. Roll back code/assets together; assess schema compatibility before database rollback. Never drop live commerce tables to reverse an application release.
