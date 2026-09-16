# ORIGINA Laravel — Agent Instructions

## Purpose

This repository is the Laravel implementation of ORIGINA™, migrated from `PHENOMVALENCE/origina-next`.

Current scope is frontend-first. Do not add persistence, authentication, APIs, commerce, payments, admin/CMS behaviour or external integrations unless the owner explicitly expands scope.

## Source of truth

For frontend work, use this priority order:

1. `PHENOMVALENCE/origina-next` current `main` implementation
2. approved ORIGINA brand/content supplied by the owner
3. `docs/DESIGN_SYSTEM.md`
4. `docs/MIGRATION_MAP.md`
5. existing Laravel implementation

The Laravel UI/UX must mirror the approved Next.js implementation unless a deliberate deviation is documented and approved.

Never invent scientific claims, approvals, patents, clinical outcomes, efficacy, credentials, statistics or institutional history.

## Required working method

Before changing a page:

1. inspect the matching Next.js route and shared components;
2. identify its layout, copy, states, responsive behaviour, interactions and assets;
3. reuse the same local brand/product/founder assets in Laravel;
4. implement with Blade, semantic HTML, CSS tokens and progressive enhancement;
5. compare the Laravel result against the Next.js source at desktop and mobile widths;
6. run the relevant checks;
7. commit one logical change at a time.

Do not replace final assets with remote hotlinks, placeholders or invented imagery.

## Engineering rules

- Laravel 12 / PHP 8.3+ conventions.
- Keep business logic out of Blade.
- Reuse Blade components for repeated UI.
- Use semantic design tokens; avoid arbitrary visual one-offs.
- JavaScript is progressive enhancement only unless an ADR approves otherwise.
- Target WCAG 2.2 AA, keyboard operation and visible focus.
- Preserve output escaping, CSRF protection and security headers.
- Protect performance: avoid unnecessary JS, third-party scripts and oversized media.

## Git ownership and attribution

All repository work is owned by the human maintainer.

- Commits must be created through the maintainer's connected GitHub account.
- Use the maintainer's configured Git author/committer identity.
- Never add AI, agent, bot or assistant names to commit authorship, co-author trailers, PR credits, changelogs or implementation credits.
- Do not add `Co-authored-by` trailers for agents.
- Do not describe implementation as authored by an agent.
- Keep commits small, coherent and reviewable.
- Never force-push shared branches.
- Never merge a PR automatically unless the owner explicitly requests it.

Branch model:

- `main` — accepted/release baseline
- `masterchanges` — current integration branch
- short-lived work — `feature/*`, `fix/*`, `docs/*`, `refactor/*`, `chore/*`

Use Conventional Commits: `feat`, `fix`, `docs`, `refactor`, `test`, `perf`, `style`, `build`, `ci`, `chore`.

## Validation

Before a PR is ready, run the applicable checks:

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm ci
npm run build
```

Never claim a check passed unless it actually ran successfully.

## Documentation

Keep documentation concise and current. Update only the documents affected by a change. Durable architecture decisions require an ADR under `docs/adr/`.

## Design guardrails

ORIGINA should remain scientific, editorial, premium and restrained. Preserve the Next.js visual language rather than redesigning it during migration.

Avoid unapproved gradients, glassmorphism, excessive shadows, decorative pill UI, novelty motion and generic SaaS styling.
