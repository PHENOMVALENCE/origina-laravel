# ORIGINA Laravel — Agent Working Instructions

## Mission

This repository is the Laravel implementation of ORIGINA™, rebuilt from `PHENOMVALENCE/origina-next` with a stricter engineering baseline. ORIGINA is presented as an evidence-led, multi-divisional innovation institution operating at the intersection of biology, clinical science, technology, human wellbeing, product development, and premium brand expression.

The current phase is **frontend-only**. Do not introduce application backend behaviour unless the owner explicitly expands scope.

## Source of truth

Before changing copy, structure, or visual language, consult:

1. `docs/PROJECT_CONTEXT.md`
2. `docs/DESIGN_SYSTEM.md`
3. `docs/ARCHITECTURE.md`
4. the existing `PHENOMVALENCE/origina-next` implementation
5. the approved public ORIGINA site/content supplied by the owner

Never invent scientific claims, clinical outcomes, approvals, patents, credentials, statistics, product efficacy, regulatory status, or institutional history.

## Current implementation boundary

Allowed now:
- Laravel 12 application shell
- Blade views and Blade components
- semantic HTML
- CSS design tokens and responsive layouts
- lightweight progressive-enhancement JavaScript
- Vite asset pipeline
- accessibility, metadata, performance and security-header scaffolding
- static placeholder routes needed to review information architecture
- tests for public view rendering and architecture boundaries

Not allowed yet:
- database migrations or production data models
- authentication or authorization flows
- checkout, carts, orders, inventory, payments or shipping
- admin/CMS persistence
- API endpoints or external integrations
- contact-form persistence or email delivery
- analytics persistence

When a future feature requires backend work, update `docs/ROADMAP.md` and create an ADR before implementation.

## Engineering standards

- PHP: PSR-12, strict types where practical, Laravel conventions, small classes, dependency injection over service location.
- Views: Blade components for repeated UI; keep business logic out of templates.
- CSS: consume semantic design tokens; no arbitrary one-off colours unless documented.
- JavaScript: progressive enhancement only; no frontend framework unless an ADR approves it.
- Accessibility: WCAG 2.2 AA target; keyboard operation and visible focus are mandatory.
- Security: treat all future input as hostile; preserve CSRF protection, output escaping, validation, authorization and secure-cookie defaults.
- Performance: protect Core Web Vitals; avoid unnecessary client JavaScript, third-party scripts and oversized images.

## Git workflow

- `main` is the protected/release branch.
- Active implementation branch for this foundation: `masterchanges`.
- Future work should use short-lived branches from updated `main`, preferably `feature/<scope>`, `fix/<scope>`, `docs/<scope>` or `chore/<scope>`.
- Never force-push shared branches.
- Never merge your own pull request automatically.
- Keep commits small, coherent and reviewable.

Conventional Commits:

`type: imperative summary`

Allowed types: `feat`, `fix`, `docs`, `refactor`, `test`, `perf`, `style`, `build`, `ci`, `chore`.

Do not add AI/agent co-author trailers. Commits belong to the repository owner.

## Required checks before a PR is ready

```bash
composer validate --strict
composer test
composer analyse
composer lint:test
npm ci
npm run build
```

If the local environment cannot execute a check, state that explicitly in the PR body. Never claim a check passed unless it actually ran.

## Documentation discipline

Architecture changes require documentation in the same PR. Update the relevant file and, when a durable technical decision is being made, add an ADR under `docs/adr/`.

## Design discipline

ORIGINA should feel authoritative before decorative: scientific institution at the parent level, premium/luxury expression through restraint, typography, materiality, photography and division-specific identities. Do not turn the institutional layer into a generic cosmetics storefront.

No gradients, glassmorphism, excessive shadows, decorative pill UI, novelty motion, or template-like SaaS visuals unless explicitly approved. Prefer whitespace, editorial typography, hairline rules, strong imagery and deliberate asymmetry.

## Content safety

Use `™` only where present in approved brand copy. Trademark marks do not imply patent or regulatory approval.

Use conservative scientific language. If evidence is preliminary, say so. Do not write approval language that has not been verified.
