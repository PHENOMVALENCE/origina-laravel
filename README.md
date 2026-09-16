# ORIGINA — Laravel

Production-grade Laravel re-platforming of ORIGINA™, an evidence-led multi-divisional innovation institution originating in Dar es Salaam, Tanzania.

The existing `PHENOMVALENCE/origina-next` project is the migration reference. This repository is intentionally starting with a **frontend-only foundation** so visual language, information architecture, security defaults, accessibility and engineering standards can be reviewed before backend and commerce complexity is introduced.

## Current status

**Foundation / frontend prototype. No production backend has been implemented.**

Implemented on `masterchanges`:
- Laravel 12 application shell
- Blade layout and reusable components
- institutional homepage prototype based on the existing ORIGINA content architecture
- responsive design system using ORIGINA semantic tokens
- placeholder public routes for information-architecture review
- security-header middleware baseline
- PHPUnit public-route checks
- Pint and Larastan configuration
- GitHub Actions CI
- project-specific system engineering, design, security, accessibility, Git and agent documentation

Explicitly not implemented yet: database, authentication, admin CMS, APIs, enquiry persistence, catalogue backend, cart, checkout, payments, orders, inventory or fulfilment.

## Requirements

- PHP 8.3+
- Composer 2
- Node.js 20+
- npm

## Local setup

```bash
git clone https://github.com/PHENOMVALENCE/origina-laravel.git
cd origina-laravel
git checkout masterchanges
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan serve
```

For frontend development, run `npm run dev` in a second terminal.

## Quality gates

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

> The first local dependency install should generate `composer.lock` and `package-lock.json`; commit both before treating builds as reproducible/production-ready.

## Documentation

| Document | Purpose |
|---|---|
| `AGENTS.md` | Rules for AI agents and contributors |
| `docs/PROJECT_CONTEXT.md` | ORIGINA product and migration context |
| `docs/ARCHITECTURE.md` | Laravel and future domain architecture |
| `docs/SYSTEM_ENGINEERING.md` | Non-functional/system standards |
| `docs/DESIGN_SYSTEM.md` | Institutional + premium visual system |
| `docs/SECURITY_MODEL.md` | Threat posture and future controls |
| `docs/ACCESSIBILITY.md` | WCAG 2.2 AA baseline |
| `docs/TESTING_QA.md` | Automated and visual QA |
| `docs/FRONTEND_SCOPE.md` | Current phase boundary |
| `docs/GIT_WORKFLOW.md` | Branch, commit and PR conventions |
| `docs/ROADMAP.md` | Phased implementation plan |
| `docs/adr/` | Architecture decision records |

## Important migration note

The homepage currently references a small number of existing `origina-next` images from GitHub raw URLs to make the frontend direction immediately reviewable without duplicating binary assets during repository bootstrap. This is temporary. Before deployment, images must be copied into this repository, optimized, given explicit responsive variants and served from ORIGINA-controlled infrastructure.

## Branching

- `main` — reviewed/release baseline
- `masterchanges` — current foundation implementation branch
- future work — short-lived `feature/*`, `fix/*`, `docs/*`, `refactor/*`, `chore/*` branches

Open a PR into `main`; do not auto-merge it.
