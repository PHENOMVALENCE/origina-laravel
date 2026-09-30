# Current platform roadmap

The owner's 30 September 2026 instruction activates backend, commerce, accounts, administration and API testing. ADR 0002 supersedes the earlier frontend-only gate.

## Implemented

- Existing institution/science/division/future/legal frontend preserved.
- Product catalogue, session bag, verified-user checkout and server-priced unpaid orders.
- Customer overview/history/order tracking/profile/password controls.
- Accounts, email verification, password reset, active/role checks and expiring Sanctum tokens.
- Admin overview, products, inventory reconciliation, orders, receipt confirmation, customer access, enquiries and publications.
- Manufacturing batches, quality review/release, serial generation, printable QR/CSV exports and revoke/verification.
- Operational audit records, private no-store/noindex responses, scheduler cleanup.
- Versioned JSON API and protected locally bundled Swagger interface.
- Transactional regression tests, locked dependencies and production configuration checker/runbooks.

## Release gates

Complete the production checklist on the actual host: database concurrency, SMTP, approved catalogue/pricing/delivery/terms, backups/restore, domain/TLS, scheduler, physical labels and smoke tests. Code passing checks is not a production deployment.

## Future integrations

- Approved online payment provider and signed webhook reconciliation.
- Refund/cancellation reconciliation beyond unpaid pending orders.
- Delivery zones/carriers/tax requirements/discounts/variants where explicitly required.
- Durable queued mail retries and external observability.
- Stronger external audit retention and manufacturing evidence-file governance.
- Additional API management endpoints where a real client needs them.
- Advanced traceability/fraud/ERP only with documented business scope.
