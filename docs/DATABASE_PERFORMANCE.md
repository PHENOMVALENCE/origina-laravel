# Database performance notes

ORIGINA uses MySQL 8+ with InnoDB in production. Domain correctness comes first; indexes below support the read/maintenance paths already used by the application rather than speculative future analytics.

## Production indexes

The production-index migration adds:

- `orders(user_id, created_at)` for customer order history and dashboard recency;
- `orders(status, created_at)` for filtered fulfilment work queues;
- `products(published, name)` for the public catalogue's published/name ordering;
- `enquiries(status, created_at)` for operational inbox filtering/counting and recency;
- `publications(status, published_at)` for public published-update selection;
- `verification_scans(created_at)` for scheduled retention cleanup;
- `audit_logs(created_at)` for newest-first operational audit review.

Existing primary, unique, foreign-key and lifecycle indexes remain in place. These additions intentionally avoid indexing long free-text content, addresses, message bodies, descriptions or audit JSON.

## Release verification

Run the migration against staging MySQL before production. Confirm migration time and table locks are acceptable for the current data volume, then inspect representative `EXPLAIN` plans if any query becomes slow. Do not add indexes blindly: every additional index increases write/storage cost.

The scheduled verification-scan retention job depends on the `created_at` index to avoid progressively scanning the full table as authenticity traffic grows.

## Monitoring

Track slow-query logs or equivalent host metrics for catalogue queries, customer/admin order lists, publication feeds, enquiry queues and verification cleanup. If usage patterns change materially, capture real query plans and production-like cardinality before changing indexes.

No index is a substitute for pagination, bounded input, transactional locking or correct lifecycle rules.
