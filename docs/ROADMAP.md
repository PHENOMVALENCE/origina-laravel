# Roadmap

## Phase 0 — Foundation

- [x] Establish repository workflow and agent rules
- [x] Capture project context from `origina-next`
- [x] Define system engineering, architecture, security, accessibility and design standards
- [x] Scaffold Laravel 12 frontend application
- [x] Add CI quality gates

## Phase 1 — Visual foundation

- [x] Build global Blade layout, header and footer
- [x] Implement ORIGINA design tokens
- [x] Implement homepage prototype
- [x] Add reusable editorial page hero and section navigation
- [x] Add institutional placeholder routes for navigation review
- [ ] Complete in-browser responsive/accessibility QA after dependency install
- [ ] Replace temporary remotely referenced design assets with optimized local assets
- [ ] Generate and commit `composer.lock` and `package-lock.json`

## Phase 2 — Full institutional frontend

### Core design surfaces

- [x] Homepage — institutional overview and visual language
- [x] About / Institution — identity, purpose, philosophy, founder and organisational architecture
- [x] ORIGINA Labs — research capabilities, continuum, horizon and knowledge archive
- [x] B-Melanox — first division/product design language and institutional product dossier

### Remaining public frontend

- [ ] Science hub and Biology First™
- [ ] Evidence, quality, regulatory and responsible-science pages
- [ ] Founder and Africa Originating
- [ ] Platforms and intellectual property
- [ ] Divisions index and remaining division presentation surfaces
- [ ] Future / institutional horizon surfaces
- [ ] Publications / updates frontend
- [ ] Contact/enquiry UI without persistence until backend phase
- [ ] Privacy and terms presentation
- [ ] SEO, structured data and content QA

### Frontend exit criteria

- [ ] All public routes use production Blade views rather than placeholders
- [ ] Responsive QA at 320, 375, 768, 1024, 1440 and wide desktop breakpoints
- [ ] Keyboard and screen-reader navigation review
- [ ] WCAG AA contrast verification for institutional and division registers
- [ ] Local, optimized images with explicit dimensions and accurate alt text
- [ ] Production metadata, canonical URLs, social cards, sitemap and robots policy

## Backend gate

Before Phase 3, approve:
- data model
- database choice
- identity/auth approach
- admin roles
- content governance
- privacy/data retention
- commerce scope
- payment providers and countries/currencies
- shipping/fulfilment model

## Phase 3 — Platform backend

To be designed after the gate; likely domains include content, catalogue, identity, enquiries and administration.

## Phase 4 — Commerce

Catalogue, inventory strategy, cart, checkout, payments, orders, fulfilment, customer communication and operations. Each financial integration requires its own security and failure-mode review.

## Phase 5 — Production hardening

Performance, observability, backups, disaster recovery, security review, accessibility audit, content/legal review, deployment runbooks and release management.
