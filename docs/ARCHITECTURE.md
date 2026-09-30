# Platform architecture

## Domain boundaries

| Domain | Records | Enforcement |
|---|---|---|
| Identity | users, password_reset_tokens, personal_access_tokens | hashed passwords, verification, active account checks, admin role, expiring tokens |
| Catalogue | products | approved content, positive integer TZS price, nonnegative available stock, draft/published visibility |
| Shopping | session cart | quantity 1–99, up to 50 distinct products; availability reviewed at placement |
| Commerce | orders, order_items | Checkout and OrderWorkflow services; transactions, locks, immutable price/name/SKU snapshots |
| Communications | enquiries, publications | consent, throttling, honeypot, escaped text, explicit editorial review |
| Manufacturing | manufacturing_batches, product_units | Traceability service; draft, quality review, release, unit revoke |
| Verification | verification_scans | random token lookup, active/released/nonexpired predicate, pseudonymous visitor hash |
| Audit | audit_logs | actor/action/subject/change metadata on operational mutations |

Foreign keys preserve historical records. Product removal is unpublishing rather than deletion. Users with orders/publications are not deleted through routine administration. There are no generic mass-assignment endpoints.

## Rendering

Public institution pages retain bespoke Blade compositions and the approved content registry. Catalogue and publication pages use Eloquent records. Customer/admin layouts are dedicated workspaces sharing the institution's fonts, square geometry, hairline rules and semantic colour tokens. No SPA state store or animation framework is required.

Business services are reused by web and JSON controllers. Web forms use Laravel CSRF middleware, sessions and validation redirects. APIs accept bearer tokens only: Sanctum's session guard is disabled for the API so cookie-authenticated web sessions cannot bypass CSRF through JSON routes. Customer order reads/cancellations enforce ownership with a 404 response. Every admin group also checks active and verified identity and the admin role.

## Concurrency and invariants

Checkout locks the user before checking the unique idempotency key. Product rows are locked in ID order, checked for publication and stock, and decremented inside the order transaction. A failed line rolls back the whole purchase. Keys identify a purchase attempt; retries reuse the same key and return the original order. A key belonging to another account cannot disclose its order.

Order transitions lock the order; cancellation locks products in ID order and returns inventory exactly once. Payment confirmation requires a unique reference. Confirmed orders require recorded payment; shipping requires a tracking reference. Paid cancellation is blocked because no automated refund reconciliation exists.

Inventory edits are absolute available-stock reconciliation. Administrators must reconcile quantities against outstanding orders rather than re-entering gross warehouse inventory. Batches and release decisions lock the batch before generating/activating units. Revocation is irreversible through routine UI.

## Side effects and operations

Order-received mail is registered after the transaction commits; mail failures are reported without undoing a valid order. Account verification/password-reset messages use native Laravel notifications. Configure reliable SMTP and monitor transport errors. There is no durable mail retry queue in this release; order history remains authoritative if delivery fails.

Private route responses use no-store/noindex. Uploaded images are validated raster formats, stored with generated names on the public disk and served through the storage link. Product verification tokens never appear in normal model serialization; approved print exports intentionally expose them to admins and are audited.

## Source references

Laravel 12 native [Sanctum](https://laravel.com/docs/12.x/sanctum) and [email verification](https://laravel.com/docs/12.x/verification) APIs. The approved `origina-next` source remains an institutional structure/content reference. Preserve institutional content governance separately from commercial records.
