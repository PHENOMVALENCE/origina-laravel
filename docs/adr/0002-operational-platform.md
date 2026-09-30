# ADR 0002 — Operational ORIGINA platform

Status: accepted under the owner's 30 September 2026 instruction.

The owner explicitly expands the frontend-only phase to backend, shopping, customer accounts, administration and Swagger API testing. Keep the approved institutional frontend and use Laravel 12, Blade, Eloquent, MySQL and Sanctum. No microservices or separate SPA.

Domains: identity, catalogue, cart, orders, enquiries, manufacturing, authenticity and audit. Controllers validate requests; services enforce money, stock and lifecycle rules in transactions. Customers access only their records. Administrators manage operational records; institution/scientific content remains reviewed in Git rather than unrestricted rich-text editing.

Money is integer TZS (whole shillings); prices and shipping are recalculated on the server. Checkout reserves stock atomically and creates an unpaid order, never a fake payment success. Manual payment confirmation is auditable. Online payment provider integration needs merchant configuration and signed webhook reconciliation before activation. Product publishing requires approved descriptions, actual prices and inventory; no fabricated saleable products are seeded.

Orders: pending → confirmed → processing → shipped → delivered. Pending may be cancelled and stock released. Confirmed/processing cancellations are deliberately excluded until an actual refund workflow exists. Manufacturing: draft → quality_review → released; serialized units verify only in released batches and active state. Verification identifies records and flags repeat scans; it cannot prove that a physical package is genuine by itself.

API: /api/v1, read-only public catalogue, Sanctum bearer tokens for private resources, role checks for all administrator operations. Swagger UI is locally bundled, disabled in production unless explicitly enabled, and administrator-only. No default administrator password. Bootstrap via an interactive CLI.

Production release gates: green tests, dependency audits, MySQL concurrency verification, HTTPS, SMTP, backups/restore drill, deployment smoke tests, approved inventory/claims, configured delivery fees and payment instructions.
