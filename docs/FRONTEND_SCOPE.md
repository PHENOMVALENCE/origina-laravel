# Frontend Scope

## Goal

Complete the public ORIGINA institutional frontend before backend implementation begins.

## In scope

- Laravel 12 public application shell;
- complete approved public route implementation;
- Blade pages/components and config-backed institutional content;
- institutional and division design systems;
- Vite CSS and progressive-enhancement JavaScript;
- responsive navigation and in-page orientation;
- native scrolling and restrained motion;
- managed imagery and CDN-ready asset URLs;
- branded loading/progress behavior;
- custom 404/500/503 states;
- canonical, Open Graph and Twitter metadata;
- sitemap and environment-aware robots policy;
- accessibility and WCAG 2.2 AA target;
- performance and layout stability;
- security-header baseline;
- public-route/content tests and CI;
- deployment/readiness documentation.

## Deliberately out of scope

Until explicitly approved:

- database/persistence;
- authentication and authorization;
- admin/CMS persistence;
- APIs and external integrations;
- enquiry submission/storage/email workflow;
- catalogue backend;
- cart, checkout, payments, orders, inventory, shipping and fulfilment.

The UI must not pretend these systems exist.

## Frontend definition of done

A public route is frontend-complete when:

1. it renders real approved content rather than a placeholder;
2. it follows the institutional/division design register;
3. its responsive layout works from narrow mobile through large desktop;
4. imagery, captions and alt text are appropriate;
5. keyboard/focus/reduced-motion behavior is correct;
6. metadata and navigation are correct;
7. no deferred backend capability is falsely represented;
8. automated route/build checks pass;
9. any intentional difference from older references is documented.

The full frontend is complete only when the route matrix, error states, assets, SEO metadata, accessibility review and release checks are all complete.
