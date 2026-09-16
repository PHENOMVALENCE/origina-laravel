# Roadmap

## Foundation — complete

- [x] Laravel 12 / Blade / Vite foundation
- [x] repository, agent and Git rules
- [x] CI, Pint, Larastan and PHPUnit baseline
- [x] shared layout/components and ORIGINA design tokens
- [x] security-header baseline
- [x] approved ORIGINA logo, mark, favicon, founder and B-Melanox assets migrated locally
- [x] Next.js navigation/footer information architecture mirrored in the Laravel shared shell

## Frontend migration — active

Completed route implementations:

- [x] `/`
- [x] `/about`
- [x] `/labs`
- [x] `/divisions/b-melanox`

Remaining Next.js parity work:

- [ ] Biology First™ and Science hub
- [ ] evidence, quality, regulatory and responsible-science pages
- [ ] Founder and Africa Originating
- [ ] Platforms and intellectual property
- [ ] Divisions index and remaining divisions
- [ ] Future surfaces
- [ ] Updates/publications
- [ ] Contact UI
- [ ] Privacy and terms

## Frontend exit criteria

- [ ] no public placeholder routes;
- [ ] every migrated route reviewed against `origina-next` at desktop and mobile widths;
- [x] no remote GitHub asset hotlinks on currently implemented production views;
- [ ] keyboard/focus and WCAG 2.2 AA review complete;
- [ ] metadata, canonical URLs, sitemap and robots policy complete;
- [ ] dependency lockfiles committed;
- [ ] CI green on the final frontend migration head.

## Backend gate

Do not begin persistence/auth/admin/commerce until the owner approves the data model, identity model, content governance, privacy/retention, payment scope and operational requirements.

## Later phases

1. platform backend: content, identity, enquiries and administration;
2. commerce: catalogue, inventory, cart, checkout, payments, orders and fulfilment;
3. production hardening: observability, backups, performance, security, accessibility and release operations.
