# Frontend Architecture

## Objective

The frontend is the complete public institutional layer of ORIGINA™. It must communicate a science-led institution before any future commerce, account, administration or operational backend is introduced.

The current implementation is server-rendered with Laravel 12, Blade and Vite. JavaScript is progressive enhancement only.

## Public rendering flow

```text
routes/web.php
  -> PublicPageController
  -> config/origina_content.php
  -> resources/views/pages/content.blade.php
  -> shared Blade components
  -> resources/css/app.css + resources/js/app.js
```

The homepage, About, Labs and B-Melanox retain dedicated views because their compositions are unusually specific. The remaining institutional, division and future routes use the shared content renderer with route-specific content and section structures.

This is not a generic page-builder. The renderer supports a deliberately small editorial vocabulary:

- page hero and in-page section navigation;
- prose and split editorial sections;
- institutional cards and numbered sequences;
- evidence/detail lists;
- controlled tags and statements;
- institutional directories;
- legal prose;
- contact directory and empty/archive states;
- closing calls to action.

New page types should reuse these primitives before introducing another structural pattern.

## Institutional versus division layer

ORIGINA has two visual registers.

### Institution

Used for the parent institution, science, evidence, founder, Africa, future, contact, legal and the divisions index.

Characteristics:

- warm paper and ivory reading surfaces;
- Origina Noir for highest emphasis;
- Origin Gold as the institutional thread;
- Warm Graphite for body/supporting copy;
- editorial serif + humanist sans hierarchy;
- squared corners and hairline structure;
- no decorative elevation;
- documentary photography and captions.

### Division

Used only when an individual division speaks in its own voice.

All divisions keep the same typography, grid, spacing, interaction, accessibility and component construction. Identity is expressed through scoped semantic colour tokens, selected imagery and controlled surface changes.

Division colour must never leak back into the parent institution.

## Interaction model

Scrolling stays native. Do not introduce scroll-jacking, forced snap points, parallax or continuous ambient motion.

Progressive enhancement currently provides:

- accessible desktop navigation panels;
- modal mobile navigation with focus containment;
- sticky-header state;
- active in-page section navigation;
- restrained one-time content reveals;
- lightweight page-navigation progress;
- image-loading state cleanup;
- reduced-motion support.

The site must remain understandable and usable if JavaScript fails.

## Loading model

There is no blocking application loader.

Server-rendered content should appear immediately. The frontend uses:

- intrinsic image dimensions to reduce layout shift;
- eager/high-priority loading only for page-defining hero imagery;
- lazy loading for below-the-fold imagery;
- background placeholders for managed editorial media;
- a thin navigation-progress indicator for internal page transitions.

Never hide meaningful content behind an artificial loading screen.

## Failure states

Custom public error views exist for:

- 404 — route not found;
- 500 — unexpected application failure;
- 503 — maintenance/unavailable state.

Error pages preserve ORIGINA’s institutional shell, offer useful routes forward and do not expose technical exception detail.

## Frontend/backend boundary

The frontend phase deliberately does not include:

- database persistence;
- authentication or accounts;
- admin/CMS persistence;
- enquiry submission/storage;
- APIs;
- catalogue backend;
- cart, checkout, payments, orders or inventory.

UI must not imply that deferred systems are operational. The contact page therefore uses direct institutional email pathways until an approved backend enquiry workflow exists.

## Definition of frontend complete

Before backend work begins:

1. every approved public route has a real implementation;
2. no public placeholder route remains;
3. institution/division visual layers are consistent;
4. desktop, tablet and mobile layouts are reviewed;
5. keyboard, focus, reduced-motion and contrast requirements are reviewed;
6. metadata, canonical URLs, sitemap and robots policy are present;
7. custom error states are present;
8. assets are optimized and CDN-ready;
9. route and content tests are green;
10. Vite production build and PHP quality gates pass;
11. documentation matches the shipped implementation.
