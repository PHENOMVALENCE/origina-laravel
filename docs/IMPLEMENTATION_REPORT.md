# Operational implementation report — 30 September 2026

## Delivered

Preserved the ORIGINA institutional frontend and extended the Laravel monolith with account identity/verification/reset, an approved-record product catalogue, session bag, transactional unpaid checkout, customer dashboard/history/profile, administrator operational overview, catalogue/inventory/order/payment/access management, consented enquiries, plain-text publications, batch/QC release/serialized units, QR/CSV print records, public record verification and audit history.

Added `/api/v1` bearer endpoints and a local Swagger UI protected by administrator web access and disabled by default in production. Native Laravel mail supports verification/reset and post-commit order-received notifications. Added a secure administrator CLI, a production-configuration checker, scheduler cleanup, immutable order-item commercial snapshots, locking/idempotency and private response cache/indexing controls.

## Executed validation

| Check | Result |
|---|---|
| Composer validate --strict | passed |
| Pint | passed |
| Larastan/PHPStan level 6 | passed; serial --debug mode because local worker sockets are restricted |
| SQLite suite | 38 passed; 1 MySQL-only concurrency test skipped |
| Local MariaDB 10.11 / MySQL driver suite | 39 passed; 439 assertions |
| Simultaneous last-unit checkout | one success, one out-of-stock; one order, stock zero |
| Vite production build | passed; Swagger is a separate admin-only bundle |
| Composer audit | no known advisories or abandoned packages |
| npm production audit | no known vulnerabilities |
| Laravel route and view caches | passed |
| Git whitespace check | passed |
| OpenAPI/runtime route coverage | passed in automated suite |

CI additionally runs against official MySQL 8.4. Local MariaDB validation establishes MySQL-compatible behavior; the exact production MySQL host/version still needs staging verification.

## Browser review

Local QA records were created only in the ignored development database; no demo saleable data or credentials were committed. Inspected the collection and desktop/mobile administrator overview visually, verified administrator login using the real browser, and confirmed protected Swagger renders.

Reviewed eleven surfaces at each of 1440, 768, 375 and 320px: institution home, shop, product detail, bag, account overview, profile, admin overview, product creation, order detail, batches and publication creation. The initial run found a six-pixel narrow-header overflow. After reducing narrow header/action gaps and keeping a 44px menu button, all 44 combinations passed document-width, loaded-image and form-label checks. Lazy images not yet requested are deliberately excluded from broken-image checks.

Browser checks are focused functional/layout verification, not a formal WCAG certification. A full real-host SMTP/payment/physical-label/deployment acceptance run remains required.

## Release boundaries

Checkout creates unpaid orders and reserves stock. Administrators confirm actual reconciled receipts. No online payment provider, signed merchant webhooks, automatic refund, multi-zone carrier service, tax engine, variants or full ERP is represented as delivered. Manufacturing provides batch/serial/QC release records; a valid code cannot independently prove physical authenticity.

Before launch, complete PRODUCTION_CHECKLIST.md on the real host: SMTP, database, HTTPS, public-only document root, scheduler, backups/restore, approved products/prices/claims, delivery area/fee, terms, payment instructions and physical label scans. Keep checkout disabled until these are confirmed. The code has not been deployed to production in this implementation phase.
