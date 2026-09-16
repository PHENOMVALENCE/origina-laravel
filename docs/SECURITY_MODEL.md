# Security Model

## Threat posture

ORIGINA is expected to become a globally reachable institutional and commerce platform. Its eventual attack surface will include public forms, authentication, administrative tooling, personal data, orders, third-party APIs and payment-provider webhooks. Security design therefore begins before those features exist.

## Current frontend phase

Even static-facing work must preserve:

- Blade escaped output (`{{ }}`) by default
- Laravel CSRF middleware for future state-changing forms
- no inline secrets
- no unreviewed third-party scripts
- dependency pinning through lockfiles
- secure response-header plan
- clear separation between public content and future administrative surfaces

## Future controls

### Authentication

- Laravel-native session authentication or a well-maintained first-party ecosystem package
- password hashing through framework APIs
- session fixation protection
- rate limiting
- optional MFA for staff/admin users
- secure password reset flows

### Authorization

Use policies/gates for resource authorization. UI visibility is not an authorization control.

### Input and output

- Form Requests for validation
- allow-list fields and enum values
- server-side validation even when client validation exists
- escape output by context
- sanitize intentionally rich HTML through an allow-list sanitizer

### HTTP/session

Production should deliberately configure CSP, HSTS, Referrer-Policy, Permissions-Policy, X-Content-Type-Options, frame restrictions and secure session cookies. CSP should be tested rather than copied blindly.

### Commerce/payments

- do not store raw payment credentials
- signed webhook verification
- idempotency keys / deduplication
- replay resistance
- order/payment state separation
- reconciliation jobs
- audit trails

### Uploads

Future uploads require MIME/content validation, size limits, randomized storage names, non-public default storage, malware scanning where justified, and image re-encoding for image uploads.

### Data privacy

Collect the minimum necessary data. Define lawful purpose, retention, deletion and access controls before production collection. Do not expose customer/order data through predictable identifiers without authorization.

## Security review triggers

Require explicit review when adding:
- authentication
- roles/permissions
- file uploads
- payment or webhook handlers
- external APIs
- admin actions
- personal-data exports
- rich-text editing
- background jobs that mutate financial/order state
