# Production acceptance checklist

Code readiness and host readiness are separate. The local build must not be described as a completed production deployment.

## Automated

- [ ] Composer validate, Pint, Larastan and PHPUnit green on the exact release commit.
- [ ] MySQL tests and simultaneous stock-reservation check green.
- [ ] Locked npm install and Vite production build green.
- [ ] Composer/npm advisories reviewed.
- [ ] Migration, route cache and view cache rehearsed.
- [ ] OpenAPI routes match runtime routes and protected Swagger loads.
- [ ] Profile/password security changes create audit records without secrets and revoke API tokens after password changes.
- [ ] Manufacturing release rejects expired batches and batches without serialized units.
- [ ] Order cancellation restores reserved inventory exactly once and paid orders cannot enter the unpaid-cancellation path.

## Host

- [ ] Correct public-only document root and supported PHP/MySQL extensions.
- [ ] APP_ENV=production, APP_DEBUG=false, stable key, HTTPS URL.
- [ ] Secure/encrypted session cookies and correct trusted proxy configuration.
- [ ] SMTP sends verification, reset and order notifications to test recipients.
- [ ] Runtime directories writable; upload storage linked and preserved across releases.
- [ ] Scheduler runs and expiry/scan cleanup observed.
- [ ] `origina:status` reports the operational platform scope accurately.
- [ ] `origina:production-check` passes; actual domain `/up` and asset URLs succeed.
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
- [ ] Batch quality evidence, serialized unit generation, printed labels and physical QR scan quality checked.
- [ ] Mobile/tablet/desktop, keyboard and reduced-motion review completed.
- [ ] Checkout enabled only after preceding gates.

## Remaining integrations

Online payment provider/webhooks, automated refunds, multi-zone shipping, variants and full ERP are not delivered integrations. SMS and online payment must remain disabled until the selected provider, production credentials, signature verification/reconciliation and acceptance tests are complete. Request a separate reviewed implementation before representing them as operational.
