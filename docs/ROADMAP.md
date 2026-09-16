# Roadmap

## Phase 0 — Foundation

- [x] Establish repository workflow and agent rules
- [x] Capture project context from `origina-next`
- [x] Define system engineering, architecture, security, accessibility and design standards
- [ ] Scaffold Laravel 12 frontend application
- [ ] Add CI quality gates

## Phase 1 — Visual foundation

- [ ] Build global Blade layout, header and footer
- [ ] Implement ORIGINA design tokens
- [ ] Implement homepage prototype
- [ ] Add institutional placeholder routes for navigation review
- [ ] Responsive/accessibility QA
- [ ] Replace temporary remotely referenced design assets with optimized local assets

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
