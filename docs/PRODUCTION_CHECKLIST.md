# Production acceptance checklist

Code readiness and host readiness are separate. A green build must not be described as a completed production deployment. Use `PRODUCTION_READINESS.md` for the release-status model and route-by-route acceptance matrix.

## Automated

- [ ] Composer validate, Pint, Larastan and PHPUnit green on the exact release commit.
- [ ] MySQL tests and simultaneous stock-reservation check green.
- [ ] Locked npm install and Vite production build green.
- [ ] Composer/npm advisories reviewed.
- [ ] Migration, route cache and view cache rehearsed.
- [ ] OpenAPI routes match runtime routes in both directions and protected Swagger loads.
- [ ] Account password/profile security regression tests green.
- [ ] Order lifecycle, reference normalization and inventory release regression tests green.
- [ ] Manufacturing release/revocation/label integrity regression tests green.
- [ ] Production response-security/CSP tests green.
- [ ] Production acceptance command regression tests green.

## Host

- [ ] Correct public-only document root and supported PHP/MySQL extensions.
- [ ] APP_ENV=production, APP_DEBUG=false, stable key, HTTPS URL.
- [ ] Secure and encrypted session cookies; safe SameSite policy; correct trusted proxy configuration.
- [ ] SMTP is configured with an approved non-placeholder sender and sends verification, reset and order notifications to test recipients.
- [ ] Runtime directories writable; upload storage linked and preserved across releases.
- [ ] Scheduler runs every minute and expiry/scan cleanup is observed.
- [ ] `origina:production-check` passes on the exact release host.
- [ ] Actual domain `/up`, canonical URLs, built assets and uploaded assets succeed over HTTPS.
- [ ] Security headers, HSTS and CSP are confirmed through the real reverse proxy/CDN path.
- [ ] Backups and restore drill complete; rollback ownership documented.
- [ ] Logs/alerts have an operational owner.

## Business

- [ ] No sample saleable records/default passwords.
- [ ] Product identity, ingredients, instructions, price, stock and claims approved.
- [ ] Tax-inclusive commercial pricing/terms approved by business owner.
- [ ] Delivery coverage and single delivery fee verified.
- [ ] Payment instructions belong to the institution and actual receipt workflow works.
- [ ] Unpaid reservation review and manual refund escalation have assigned owners.
- [ ] Privacy notice, rights/contact process, data retention and hosting access reviewed.
- [ ] Batch quality evidence, printed labels and physical QR scan quality checked.
- [ ] Mobile/tablet/desktop, keyboard and reduced-motion review completed.
- [ ] Enquiry/publication workflows reviewed by responsible operators.
- [ ] Checkout enabled only after all preceding gates.

## External integrations

- [ ] Stripe remains disabled unless merchant credentials, signed webhooks, idempotent reconciliation, amount/currency checks, failure handling, refund rules and sandbox/live acceptance are complete.
- [ ] SMS remains disabled unless the selected provider, sender identity, credentials, delivery/error behavior and production acceptance are complete.

Online payment provider/webhooks, automated refunds, multi-zone shipping, variants and full ERP are not operational merely because interfaces or configuration boundaries exist. Request and complete separate reviewed implementations before representing them as delivered integrations.
