# Architecture

## Current architecture

- Laravel 12 / PHP 8.3+;
- Blade server-rendered public views;
- Vite for CSS/JS assets;
- lightweight progressive-enhancement JavaScript;
- config-backed public content during the frontend phase;
- PHPUnit, Pint and Larastan quality gates.

## Public frontend

The public frontend has two rendering paths.

### Bespoke editorial pages

Home, About, Labs and B-Melanox use dedicated Blade views because their composition is unusually specific.

### Content-driven institutional pages

`PublicPageController` resolves route content from `config/origina_content.php` and renders `resources/views/pages/content.blade.php`.

The content renderer is intentionally constrained to an editorial vocabulary rather than acting as a general page builder.

Route flow:

```text
routes/web.php
  -> PublicPageController
  -> config/origina_content.php
  -> pages/content.blade.php
  -> shared components
```

See `FRONTEND_ARCHITECTURE.md`.

## Navigation/content registries

- `config/origina.php` — navigation, footer and division registry;
- `config/origina_content.php` — public institutional/division/future page content;
- dedicated views — composition-heavy pages.

The eventual backend/CMS may replace selected config content, but frontend templates should not assume persistence yet.

## Asset architecture

Vite manages bundled CSS/JS. Public editorial media is repository-managed and referenced through `asset()`.

Optional CDN delivery is configured through `ASSET_URL`, not hard-coded hostnames.

See `ASSET_DELIVERY.md`.

## Metadata and discovery

The shared layout provides canonical and social metadata. Public endpoints provide:

- `/robots.txt`;
- `/sitemap.xml`;
- `/up` Laravel health endpoint.

See `SEO_METADATA.md`.

## Boundaries

Do not add database, auth, admin persistence, APIs, enquiry persistence or commerce until explicitly approved.

When backend work begins, keep domain boundaries clear around content, identity, enquiries, catalogue, commerce, payments, orders, manufacturing/traceability and administration.

Durable architecture changes require an ADR.

## Principles

- server-render first;
- business logic out of Blade;
- controlled reusable primitives;
- semantic design tokens;
- progressive enhancement;
- graceful no-JavaScript behavior;
- accessibility/security defaults;
- external integrations behind explicit boundaries;
- simple Laravel-native solutions before additional frameworks.
