# Architecture

## Current architecture

- Laravel 12 / PHP 8.3+
- Blade for server-rendered public views
- Vite for CSS/JS assets
- lightweight progressive-enhancement JavaScript
- static/config-backed public content during the frontend phase
- PHPUnit, Pint and Larastan for quality gates

## Frontend migration model

`PHENOMVALENCE/origina-next` is the approved UI/UX source. Next.js route components map to Blade pages; shared React components map to Blade components; `globals.css` design language maps to `resources/css/app.css`; approved public assets map into Laravel `public/` paths.

## Boundaries

Do not add database, auth, admin persistence, APIs, enquiry persistence or commerce until explicitly approved.

When backend work begins, keep domain boundaries clear around content, identity, enquiries, catalogue, commerce, payments, orders and administration. Durable architecture changes require an ADR.

## Principles

- server-render first;
- keep business logic out of Blade;
- use reusable components and semantic tokens;
- preserve security/accessibility defaults;
- keep external integrations behind explicit interfaces;
- prefer simple Laravel-native solutions over unnecessary framework complexity.
