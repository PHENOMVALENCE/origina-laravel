# ORIGINA — Laravel

Laravel re-platforming of ORIGINA™ using `PHENOMVALENCE/origina-next` as the approved frontend reference.

## Current phase

Frontend-first migration on top of Laravel 12 / Blade / Vite.

Implemented:

- Laravel application shell and shared Blade layout/components;
- homepage, About, Labs and B-Melanox public experiences;
- responsive institutional/division design system;
- security headers, public-route tests, Pint, Larastan and CI;
- local migration of approved ORIGINA brand, founder and B-Melanox imagery.

Still intentionally deferred:

- database and persistence;
- authentication/authorization;
- admin/CMS;
- APIs and external integrations;
- enquiries/email delivery;
- catalogue, cart, checkout, payments, orders, inventory and fulfilment.

## Frontend parity rule

`origina-next` is the visual and interaction source of truth during migration. Laravel pages should reproduce its layout, copy, responsive behaviour, navigation, components and assets unless a deviation is explicitly approved and documented.

## Setup

```bash
git clone https://github.com/PHENOMVALENCE/origina-laravel.git
cd origina-laravel
git checkout feature/core-frontend
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

Use `npm run dev` during frontend development.

## Quality gates

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

## Repository rules

Read `AGENTS.md` before implementation. Git history belongs to the human maintainer: do not add AI/agent/bot authorship, co-author trailers or implementation credits.

Core documentation lives in `docs/`, especially:

- `PROJECT_CONTEXT.md`
- `MIGRATION_MAP.md`
- `DESIGN_SYSTEM.md`
- `GIT_WORKFLOW.md`
- `TESTING_QA.md`
- `ROADMAP.md`

`main` is the accepted baseline, `masterchanges` is the current integration branch, and active work should use short-lived branches such as `feature/*`, `fix/*`, `docs/*` and `chore/*`.
