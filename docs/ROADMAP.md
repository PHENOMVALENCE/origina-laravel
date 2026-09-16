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
- [x] Add institutional placeholder routes for navigation review
- [ ] Complete in-browser responsive/accessibility QA after dependency install
- [ ] Replace temporary remotely referenced design assets with optimized local assets
- [ ] Generate and commit `composer.lock` and `package-lock.json`

## Phase 2 — Full institutional frontend

- [ ] Port approved public institutional pages from the existing project
- [ ] Port division presentation surfaces
- [ ] Establish publications/updates frontend
- [ ] Implement contact/enquiry UI without persistence until backend phase
- [ ] SEO, structured data and content QA

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
