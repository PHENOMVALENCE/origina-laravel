# Deployment

## Scope

This document covers the public Laravel frontend deployment baseline. It does not prescribe a hosting vendor.

## Required production environment

At minimum:

```dotenv
APP_NAME=ORIGINA
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<canonical-public-host>
ASSET_URL=
LOG_LEVEL=warning
```

`ASSET_URL` is optional. Set it only when an approved CDN/static-asset origin is configured.

Never deploy production with `APP_DEBUG=true`.

## Build

A production release should install pinned dependencies and build assets:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Run database migration commands only after backend persistence exists and the release explicitly requires them.

## Validation before promotion

Run the repository quality gates before a release is promoted:

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

Also review:

- homepage, longest institutional page and a dark division page;
- 404 page;
- mobile navigation;
- sitemap and robots;
- canonical/OG metadata;
- favicon, CSS, JS and images;
- reduced-motion behavior;
- application health endpoint `/up`.

## Web server

The web root must be Laravel's `public/` directory.

The platform should:

- force HTTPS;
- send the real scheme/host through trusted proxy configuration;
- deny access to `.env`, source files, storage internals and VCS metadata;
- support compressed static assets;
- set appropriate cache headers for static files;
- route non-file requests to `public/index.php`.

## Laravel runtime

Production should use supported PHP 8.3+ with required Laravel extensions.

Use a process/runtime configuration appropriate to the hosting environment. Do not use `php artisan serve` as the production web server.

## Caching

Recommended:

- Vite fingerprinted CSS/JS: long-lived immutable caching;
- stable public images: long-lived caching with controlled invalidation;
- HTML: avoid broad public caching until route-specific cache behavior is explicitly designed;
- private/authenticated responses in later phases: never cache publicly by default.

See `ASSET_DELIVERY.md`.

## Maintenance and errors

Laravel maintenance mode should render the branded 503 experience where applicable. Public 404/500/503 templates must remain dependency-light so they can render when application features fail.

## Security

Production response headers are applied through `SecurityHeaders`. HSTS is emitted only for secure production requests.

A Content Security Policy should be introduced only after the final production asset/font/CDN hosts are known and tested. Do not copy a generic CSP that blocks the application or silently weakens protections with broad wildcards.

## Observability

Before calling the system production-ready, establish:

- centralized application/error logs;
- uptime monitoring of the public host and `/up`;
- deployment/release identifiers;
- alert ownership;
- a rollback procedure.

Application analytics are optional and must remain privacy-conscious.

## Rollback

Every deployment should be traceable to a Git commit. Keep the previous known-good release deployable. Rollback must restore application code and built assets together so hashed Vite references do not drift from available files.
