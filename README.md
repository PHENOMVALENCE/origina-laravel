# ORIGINA — Laravel

Laravel implementation of ORIGINA™, a science-led multi-divisional institution built around Biology First™, research, evidence, formulation science and long-term institutional capability.

## Current phase

**Frontend completion before backend.**

The public frontend now includes:

- Laravel 12 / Blade / Vite application shell;
- complete institutional route architecture;
- dedicated Home, About, Labs and B-Melanox experiences;
- content-driven Founder, Africa, Science, Evidence, Platforms, IP, divisions, future, contact and legal surfaces;
- institution/division semantic design system;
- responsive navigation and restrained progressive interactions;
- local/CDN-ready media delivery;
- canonical/social metadata, sitemap and robots;
- branded 404/500/503 states;
- security headers and route/content tests.

Still intentionally deferred:

- database/persistence;
- authentication/authorization;
- admin/CMS persistence;
- APIs/external integrations;
- enquiry storage/email workflow;
- catalogue, cart, checkout, payments, orders, inventory and fulfilment.

## Reference relationship

`PHENOMVALENCE/origina-next` remains an approved source for content, information architecture and historical frontend intent.

The Laravel design system is the active implementation standard under the approved institutional frontend revision.

## Local setup

```bash
git clone https://github.com/PHENOMVALENCE/origina-laravel.git
cd origina-laravel
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

Use `npm run dev` during active frontend development.

For normal contribution work, branch from the current integration baseline according to `docs/GIT_WORKFLOW.md`.

## Optional asset CDN

Set `ASSET_URL` only when an approved CDN/static asset origin exists:

```dotenv
ASSET_URL=https://cdn.example.com
```

Leave it empty for same-origin/local assets.

## Quality gates

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

## Documentation

Read `AGENTS.md` before implementation.

Core documentation:

- `DESIGN.md` / `docs/DESIGN_SYSTEM.md`
- `docs/FRONTEND_ARCHITECTURE.md`
- `docs/FRONTEND_SCOPE.md`
- `docs/CONTENT_GOVERNANCE.md`
- `docs/ASSET_DELIVERY.md`
- `docs/SEO_METADATA.md`
- `docs/ACCESSIBILITY.md`
- `docs/TESTING_QA.md`
- `docs/DEPLOYMENT.md`
- `docs/ROADMAP.md`
- `docs/GIT_WORKFLOW.md`

Git history belongs to the human maintainer. Do not add AI/agent/bot authorship or co-author trailers.

`main` is the accepted baseline, `masterchanges` is the integration branch, and active work uses focused short-lived branches.
