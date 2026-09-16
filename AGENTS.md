# ORIGINA Laravel — Agent Rules

## Purpose

This repository re-platforms `PHENOMVALENCE/origina-next` into Laravel 12. The current scope is the public frontend: preserve the approved ORIGINA information architecture, UI/UX, content and assets before backend or commerce work begins.

## Source of truth

For migration work, use this order:

1. `PHENOMVALENCE/origina-next` on `main` for current public UI/UX, copy and asset usage.
2. `docs/FRONTEND_SCOPE.md` and `docs/MIGRATION_MAP.md` for Laravel parity status.
3. `docs/DESIGN_SYSTEM.md`, `docs/ARCHITECTURE.md` and approved owner decisions.

Do not invent scientific, clinical, efficacy, regulatory, patent, credential or institutional claims.

## Current boundary

Allowed: Blade views/components, semantic HTML, CSS, progressive JavaScript, Vite, local public assets, metadata, accessibility, performance work, public-route tests and documentation.

Deferred unless the owner explicitly expands scope: database models/migrations, authentication, authorization, admin/CMS persistence, APIs, external integrations, enquiry persistence/email, catalogue backend, cart, checkout, payments, orders, inventory, shipping and fulfilment.

## Frontend parity rule

The Next.js public frontend is the migration reference. Before calling a route complete, compare:

- content and information hierarchy
- header/footer/navigation behaviour
- sections, ordering and calls to action
- typography, spacing, colour, rules and responsive behaviour
- imagery, logo/mark usage, alt text and captions
- interaction states, keyboard behaviour and reduced motion

Assets must be served locally from this repository. Do not hotlink the reference repository in production code.

## Engineering rules

- Follow Laravel conventions and PSR-12; keep business logic out of Blade.
- Reuse Blade components for repeated UI.
- Use semantic design tokens rather than arbitrary colours.
- Keep JavaScript progressive and small; a new frontend framework requires an ADR.
- Target WCAG 2.2 AA, visible focus, keyboard operation and reduced-motion support.
- Preserve Laravel escaping, CSRF/security defaults and secret hygiene.
- Keep public pages lightweight; use explicit image dimensions and responsive assets where practical.

## Git and authorship

All repository work belongs to the human project owner. Agents are implementation tools, not repository authors.

- Use the owner's connected GitHub account and configured Git identity for every branch, commit and PR.
- Never add an agent, AI system, bot or tool as commit author, committer, co-author, contributor or implementation credit.
- Never add `Co-authored-by`, `Generated-by`, AI attribution, agent signatures or self-credit to commits, PRs, changelogs, documentation or source comments.
- If a tool cannot preserve human authorship, stop before committing and leave the change for the owner to commit.
- Keep commits small and coherent using Conventional Commits: `type: imperative summary`.
- Use short-lived `feature/*`, `fix/*`, `docs/*`, `refactor/*` or `chore/*` branches.
- Stacked PRs are allowed while parent work is still under review; target the immediate parent branch and retarget after it merges.
- Never force-push shared branches or merge a PR automatically. Merge remains an explicit human action.

## Validation

Run the checks that apply and report only checks that actually ran:

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

Use `npm ci` when `package-lock.json` exists; until lockfiles are committed, use the repository's current CI install command and document that limitation.

UI changes also require route-by-route responsive, keyboard and visual parity review against `origina-next`. Update documentation in the same PR when scope, architecture, design rules or parity status changes.
