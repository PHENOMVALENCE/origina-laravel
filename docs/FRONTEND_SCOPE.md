# Frontend Scope

## In scope

- Laravel 12 public application shell;
- Blade pages/components;
- Vite CSS and progressive-enhancement JavaScript;
- exact migration of approved `origina-next` UI/UX, copy and responsive behaviour;
- local ORIGINA assets;
- accessibility, metadata, performance and security-header work;
- progressive interaction polish: native scrolling, restrained motion, active section context, keyboard-safe menus and reduced-motion support;
- public-route tests and CI.

## Out of scope until explicitly approved

- database/persistence;
- authentication and authorization;
- admin/CMS behaviour;
- APIs and external integrations;
- enquiry storage/email delivery;
- catalogue backend;
- cart, checkout, payments, orders, inventory, shipping and fulfilment.

## Definition of done for a migrated page

The Laravel route matches the approved Next.js route in structure, copy, assets and responsive behaviour; preserves the approved visual identity; uses the shared ORIGINA interaction language for smooth, accessible state changes; passes applicable automated checks; and has no undocumented visual deviation. Smoothness must never rely on scroll-jacking, heavy animation libraries or motion that ignores user preferences.
