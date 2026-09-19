# ORIGINA Laravel — Agent Instructions

## Purpose

This repository is the Laravel implementation of ORIGINA™.

Current scope is **frontend completion first**. Do not add persistence, authentication, APIs, commerce, payments, admin/CMS behaviour, enquiry persistence or external integrations unless the owner explicitly expands scope.

## Source of truth

For frontend work, use this priority order:

1. explicit current instruction from the ORIGINA owner;
2. this repository's current design/architecture documentation;
3. approved ORIGINA brand and scientific content;
4. `PHENOMVALENCE/origina-next` for approved content, information architecture and established interaction intent;
5. the existing Laravel implementation.

The owner has explicitly approved a complete institutional frontend refinement. `origina-next` is therefore a **content and structural reference**, not a requirement for pixel-for-pixel replication. Preserve approved meaning and assets while improving institutional coherence, accessibility, responsiveness, performance and production readiness.

Never invent scientific claims, approvals, patents, clinical outcomes, efficacy, credentials, statistics or institutional history.

## Required working method

Before changing a public surface:

1. inspect the relevant Laravel implementation and documentation;
2. inspect the corresponding `origina-next` source when it contains approved content or useful structure;
3. identify content status, responsive behaviour, interactions and assets;
4. implement with Blade, semantic HTML, semantic CSS tokens and progressive enhancement;
5. preserve the institutional-versus-division visual boundary;
6. review mobile, tablet and desktop behaviour;
7. run the relevant checks;
8. commit one logical change at a time.

Do not replace final assets with remote hotlinks, placeholders or invented imagery.

## Engineering rules

- Laravel 12 / PHP 8.3+ conventions.
- Server-render first.
- Keep business/domain logic out of Blade.
- Reuse Blade components and the content registry for repeated public patterns.
- Use semantic design tokens; avoid arbitrary visual one-offs.
- JavaScript is progressive enhancement only unless an ADR approves otherwise.
- Target WCAG 2.2 AA, keyboard operation and visible focus.
- Preserve output escaping, CSRF protection and security headers.
- Protect performance: avoid unnecessary JS, third-party scripts, scroll-jacking and oversized media.
- Route repository-managed assets through Laravel's asset boundary so CDN delivery remains configurable.
- Do not imply deferred backend functionality is operational.

## Git ownership and attribution

All repository work is owned by the human maintainer.

- Commits must be created through the maintainer's connected GitHub account.
- Use the maintainer's configured Git author/committer identity.
- Never add AI, agent, bot or assistant names to commit authorship, co-author trailers, PR credits, changelogs or implementation credits.
- Do not add `Co-authored-by` trailers for agents.
- Keep commits small, coherent and reviewable.
- Never force-push shared branches.
- Never merge a PR automatically unless the owner explicitly requests it.

Branch model:

- `main` — accepted/release baseline;
- `masterchanges` — integration branch;
- short-lived work — `feature/*`, `fix/*`, `docs/*`, `refactor/*`, `chore/*`.

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

Keep documentation concise and current. Update the documents affected by a change. Durable architecture decisions require an ADR under `docs/adr/`.

Key frontend documents:

- `DESIGN.md`
- `docs/DESIGN_SYSTEM.md`
- `docs/FRONTEND_ARCHITECTURE.md`
- `docs/ASSET_DELIVERY.md`
- `docs/SEO_METADATA.md`
- `docs/CONTENT_GOVERNANCE.md`
- `docs/TESTING_QA.md`
- `docs/DEPLOYMENT.md`

## Design guardrails

ORIGINA is a science-led institution. The parent layer must feel calm, evidence-forward, elegant, editorial and permanent.

Prefer warm paper, precise typography, hairline structure, documentary photography, controlled Origin Gold and deliberate whitespace.

Avoid generic SaaS styling, cosmetic-site overstatement, glassmorphism, decorative gradients, rounded-card systems, excessive shadows, novelty motion and visual effects that weaken institutional credibility.
