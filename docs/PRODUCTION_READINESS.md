# ORIGINA production readiness

This document separates repository readiness from host readiness and external-service activation. A green CI build means the code satisfies automated repository checks; it does not mean the public production system has completed operational acceptance.

## Status model

| Status | Meaning |
|---|---|
| Code-ready | Implemented in the repository and covered by automated/static checks where applicable. |
| Staging-required | Requires a real MySQL/HTTPS/SMTP/browser/cron/storage environment before production acceptance. |
| External-blocked | Intentionally disabled until a real provider account, credentials and provider-specific acceptance exist. |
| Business-blocked | Requires owner approval of commercial, scientific, legal or operational content/data. |

## Code-ready capabilities

The repository provides the institutional public site, catalogue discovery, authenticated customer accounts, email verification/password reset, cart and server-priced checkout, unpaid order placement, manual payment reconciliation, order fulfilment, catalogue administration, customer access management, enquiries, publications, manufacturing batches, serialized unit authenticity, audit history, Sanctum bearer API, protected Swagger/OpenAPI testing, security middleware and production diagnostics.

Domain behavior is fail-closed around inventory, order status transitions, payment references, customer ownership, administrator access, manufacturing release and product-unit revocation. Client-supplied prices/payment success are not trusted.

## Public and customer release surfaces

Before launch, manually review each route class at mobile, tablet and desktop widths:

| Surface | Primary acceptance |
|---|---|
| `/` and institutional pages | headings, content accuracy, scientific claims, imagery, navigation, metadata, keyboard focus, reduced motion |
| `/shop` | search/filter, empty state, product imagery, approved prices, stock state |
| `/shop/{product}` | product identity, ingredients/use/evidence content, quantity bounds, out-of-stock state |
| `/cart` | quantity changes, unavailable-stock handling, totals language, navigation |
| `/login`, `/register`, password and verification flows | SMTP delivery, validation, session behavior, no indexing/cache |
| `/checkout` | verified account requirement, address validation, configured shipping fee, approved payment instructions, disabled-state behavior |
| `/account*` | ownership isolation, order status clarity, profile/password changes, responsive tables/navigation |
| `/enquire` | valid topics, consent, anti-spam behavior, acknowledgement |
| `/updates*` | draft isolation, publication timestamps, escaped content |
| `/verify/{token}` | physical QR readability, valid/revoked/expired behavior, privacy-preserving scan records |

## Administrator release surfaces

Review `/admin` and every linked workspace with an actual restricted administrator account. Confirm catalogue create/edit/archive, stock handling, payment receipt confirmation, lifecycle transitions, dispatch references, people/access controls, enquiry states, publication draft/publish workflow, batch creation/review/release, label export, revocation and audit entries.

Administrator and account responses must remain `no-store`/`noindex`; access attempts by ordinary customers must fail. API docs must remain disabled in production unless intentionally enabled for an administrator-only operational need.

## Staging-required gates

The following cannot be proven solely by repository review:

1. MySQL 8+ connection, migrations, row-lock/concurrency behavior and production indexes on the actual host.
2. HTTPS termination, canonical domain, trusted proxy behavior, HSTS/CSP/security headers and secure cookies.
3. SMTP verification, password-reset and order-notification delivery to real test recipients.
4. `public/` document root, uploaded-media persistence, `storage:link`, file permissions and release-to-release asset consistency.
5. Minute-level scheduler execution and observed token/verification-scan cleanup.
6. Backup schedule, encryption, restore drill and rollback rehearsal.
7. Real browser QA for WCAG 2.2 AA targets, keyboard use, reduced motion, 320/375/768/1440 layouts and horizontal overflow.
8. Physical printed QR labels and scans on representative devices.
9. Monitoring ownership for `/up`, Laravel errors, SMTP failures, unusual authentication/API/verification traffic and stale unpaid reservations.

Run `php artisan origina:production-check` on the actual release host after build, migration, storage linking and production environment configuration. Every `FAIL` must be resolved before launch. Warnings require an explicit operational decision.

## External-blocked capabilities

### Stripe

The integration boundary may be prepared in code, but Stripe must remain disabled until the real merchant account and keys exist. Production activation additionally requires sandbox/live acceptance, signed webhook verification, idempotent event handling, amount/currency reconciliation, failure handling, refund rules and operational reconciliation ownership. Do not treat a redirect/session creation as successful payment.

### SMS

SMS must remain disabled until an actual provider, sender identity, credentials, delivery rules and message templates are approved. Provider-specific request signing/authentication, error handling, delivery reporting, rate/cost controls and production tests are required before activation.

## Business-blocked gates

The owner must approve all saleable products, identity/SKU, ingredients, usage instructions, evidence wording, scientific claims, price, stock, delivery coverage/fee, payment instructions, commercial terms, privacy wording and any regulatory-facing language. Checkout stays disabled until these approvals and the staging-required gates are complete.

## Release decision

A production release is acceptable only when:

- exact release-commit CI is green;
- production diagnostics pass on the target host;
- staging-required gates have evidence and an assigned owner;
- business content/commercial data are approved;
- external integrations are either fully accepted or explicitly disabled;
- rollback and backup/restore procedures are documented and rehearsed.

If any of those conditions are unresolved, describe the system as code-ready or staging-ready rather than production-complete.
