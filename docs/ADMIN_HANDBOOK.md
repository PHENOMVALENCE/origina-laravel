# Administrator handbook

## Access and provisioning

Run `php artisan origina:admin` over a trusted CLI session. It prompts for name, unique email and a password of at least 12 characters with letters and numbers. No password is supplied on the command line, seeded or printed. This creates a verified admin and an audit entry. Customer registration always creates a customer; request-supplied role/active fields are ignored.

Sign in at `/login`, then open `/admin`. Access requires an active verified admin. People & access permits changing another person's role and activation. Self-demotion/deactivation is blocked, preserving an active administrator. Deactivation denies existing sessions on their next request and revokes tokens. Demotion immediately removes administrator privileges.

## Overview

Dashboard figures come from actual database queries, not static sample numbers: paid-order receipts, pending orders, customer count, new enquiries, fulfilment state counts, recent orders and published products with ≤5 available units. These are operational summaries, not audited financial statements.

## Catalogue

Create/edit products with unique SKU and slug, division, approved description, final TZS price and available stock. Add ingredients/use/evidence notes and select approved repository photography or upload a JPG/PNG/WebP ≤4 MB. Publication exposes the product to customers. Archive removes it from sale without destroying history. Reconcile available inventory carefully; outstanding orders already reserve units.

## Orders and receipts

Open an order to review its immutable items and delivery details. Verify actual funds before recording the unique bank/payment reference and receipt checkbox. Advance through confirmation → processing → shipped → delivered. Dispatch needs a reference. Unpaid pending orders may be cancelled; paid cancellations/refunds are intentionally blocked. Every mutation is audited.

## Enquiries and publications

Enquiries include name/email/topic/message and consent time. Mark new → in progress → closed as the team follows up. There is no automatic email response to the visitor beyond the submission acknowledgement on screen.

Publications provide draft/published news, research and update records with title, slug, summary and plain text body. A review checkbox requires explicit claims/rights/privacy review. Content is escaped; no arbitrary HTML or executable scripts are accepted. Unpublish by saving as draft. Scientific institutional pages remain maintained in Git under content review.

## Manufacturing and authenticity

Create a batch against a product with code, manufacturing date and optional expiry. Generate up to 500 serialized units per request while draft. Submit to quality review with notes/evidence references. Release only after physical quality evidence is approved; release activates non-revoked units. Download private CSV print data or open a unit's printable QR label. Revoke compromised units. See TRACEABILITY.md for the precise verification meaning.

## Audit and API laboratory

Audit entries show actor ID, timestamp, action, record and selected changes. The UI has no edit/delete action. Database operators can still alter records: strict evidentiary immutability would need external append-only storage and tighter database permissions.

Swagger at `/admin/api-docs` uses the current site's `/api/v1`; requests mutate that environment. Prefer a staging database. Obtain a verified account token from `/api/v1/tokens`, use Authorize, and revoke when done. Production docs require explicit `API_DOCS_ENABLED=true` and still require an admin session.

## Administrative boundaries

The release has no unrestricted institutional page builder, payroll, accounting ledger, supplier/procurement ERP, automated refunds or payment gateway. Those need documented business rules and integrations. All delivered screens manage real records and explicitly show empty states when no records exist.
