# Security model

Authentication uses hashed passwords (minimum 12 characters with letters/numbers), native verification/reset notifications, session regeneration, CSRF-protected web forms and login throttling. Reset tokens expire after 60 minutes; API tokens expire after 8 hours. Password reset/change revokes API tokens. Authenticated web workspaces use session password revalidation. API auth accepts bearer tokens only and cannot reuse cookies to bypass web CSRF.

Authorization is enforced on route groups and request authorization. Active/verified identity precedes protected operations. Customer orders are filtered/checked by owner; unauthorized record IDs return 404. Admin privileges cannot be supplied through registration/profile mass assignment. Administrators cannot disable/demote themselves. Account deactivation revokes tokens and blocks sessions; role demotion blocks admin actions immediately.

Products/enquiries/publications use bounded validation and escaped Blade output. Raster image uploads are MIME/extension/size restricted and renamed on the public disk; SVG uploads are rejected. Web servers must disable script execution within upload directories.

Money and inventory are recalculated inside database transactions. Ordered snapshots preserve commercial history. Locks protect placement/cancellation/lifecycle changes. Actual receipt references are unique. There is no gateway endpoint accepting arbitrary successful payment claims.

Private/admin/API/cart/checkout/auth/verification responses are no-store/noindex. Baseline headers include MIME sniffing protection, frame denial, strict-origin referrer policy, restrictive permissions policy, cross-origin opener/resource isolation and cross-domain policy denial. Production responses additionally emit a Content Security Policy that limits executable scripts and network connections to the ORIGINA origin, denies plugins and framing, restricts form submissions to the same origin, permits only the approved Google Fonts stylesheet/font hosts and upgrades insecure subresources. Production HTTPS also receives HSTS. Any future CDN, analytics, payment or other third-party browser integration must be deliberately added to the policy and reviewed before launch.

Enquiries reject a honeypot and are throttled. Verification uses random tokens and rate limiting; raw IP/device/location information is not stored in scan records.

Audit records cover operational mutations, receipt confirmation, access changes, batch releases, label exports and unit revocation. Application UI does not edit the audit trail, but privileged database operators can; this is not cryptographic immutability.

Protect database backups, uploaded images and print exports. Only restricted admins may obtain verification URLs for label printing. Scheduled pruning removes expired tokens and >90-day scans. Other retention periods need operational/legal approval; the platform does not automatically delete order history or enquiries.

SMTP, backup restore, host security, support response and refund escalation are operational obligations. No default admin, demo saleable product or hard-coded secret is introduced.
