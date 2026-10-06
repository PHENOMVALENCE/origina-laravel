# ORIGINA Frontend Architecture Audit — October 2026

## Scope

This audit covers the full Laravel presentation layer: public institutional pages, navigation, division pages, collection/shop, product detail, bag, checkout, authentication, customer account, administrator workspace, forms, tables, feedback states, responsive behavior and accessibility-oriented interaction patterns.

## Executive finding

The existing frontend is functionally complete and content-rich, but it accumulated presentation layers across several implementation phases. The result is a capable interface with inconsistent spatial rhythm, mixed geometry, different treatment of operational versus public surfaces, and a heavier-than-necessary visual hierarchy in dense admin pages.

The modernization therefore uses one cross-surface design layer rather than page-specific cosmetic patches. It preserves ORIGINA's institutional/scientific positioning and serif/sans typography while bringing navigation, cards, forms, commerce and workspaces into a coherent modern system.

## Audit findings

### 1. CSS architecture

Previous state:
- `resources/css/app.css` carries the original institutional design system.
- `resources/css/platform.css` adds commerce, forms, auth and workspace surfaces.
- public pages additionally load `public/css/production-refinement.css`.
- portal pages additionally load `public/css/portal-refinement.css`.

Risk:
- later product phases depend on selector ordering rather than one explicit cross-surface layer;
- visual changes can regress another surface because responsibility is spread across files;
- public and operational UI can drift apart.

Revision:
- add `resources/css/modern.css` as the deliberate final design layer;
- load it after legacy/refinement styles in both site and portal layouts;
- use it as the convergence layer while old selectors are retired incrementally.

### 2. Navigation and global shell

Observed issues:
- primary navigation and commerce links use different interaction treatments;
- desktop density becomes high as institutional and commerce navigation coexist;
- mobile navigation is functional but visually separate from the refined desktop experience;
- header hierarchy has limited visual differentiation between idle and scrolled states.

Revision:
- glass-like restrained sticky shell with clearer scrolled elevation;
- unified pill interaction language for navigation and account/commerce actions;
- clearer active/hover treatment without relying on underline-only state;
- mobile menu surfaces aligned to the same component vocabulary.

### 3. Typography and hierarchy

Observed issues:
- strong editorial typography already exists, but several page types use different spacing and heading density;
- large content pages can become visually flat because text hierarchy is stronger than surface hierarchy.

Revision:
- tighter display tracking;
- larger but more disciplined hero scale;
- standardized section spacing;
- reduced visual noise in body copy through consistent muted text color and reading widths.

### 4. Public institutional pages

Observed issues:
- page structures are semantically sound but vary between editorial splits, directories and evidence blocks;
- image containers and cards do not always share geometry or depth treatment.

Revision:
- shared modern radius, borders and restrained depth;
- consistent image framing;
- consistent section header rhythm;
- preserve Biology First™ institutional tone rather than converting public pages into generic SaaS marketing pages.

### 5. Commerce journey

Observed issues:
- the collection and product journey is structurally complete;
- product grids and order-summary surfaces feel more utilitarian than the public institution layer;
- shopping surfaces inherit square legacy geometry and can feel visually older than the rest of the experience.

Revision:
- modern product-media framing and hover behavior;
- more generous catalogue spacing;
- refined product-detail composition;
- stronger sticky order summary hierarchy;
- bag imagery, forms and pricing surfaces aligned with the same premium institutional system.

### 6. Authentication

Observed issues:
- split-screen auth architecture is good but visually disconnected from the modernized public and portal experience;
- forms need stronger focus state consistency.

Revision:
- refined dark scientific/editorial story panel;
- modern form controls with accessible focus rings;
- responsive single-column fallback retained.

### 7. Customer and administrator portal

Observed issues:
- sidebar workspace is functional but dense;
- stat cards use contiguous table-like framing;
- operational tables and workspace panels read as older admin UI compared with the public brand;
- mobile conversion from fixed sidebar to horizontal navigation works but needs simpler spacing.

Revision:
- wider, calmer sidebar with rounded active states;
- independent stat cards instead of one contiguous grid box;
- consistent surface cards, borders and shadows;
- sticky translucent top bar;
- improved responsive collapse at 900px and compact mobile handling below 430px.

### 8. Forms and controls

Observed issues:
- controls are usable and accessible but visually rigid;
- focus state treatment differs from more modern components.

Revision:
- consistent 49px control target;
- rounded control geometry;
- explicit gold-tinted focus halo;
- retained error attributes and semantic labels.

### 9. Tables and dense operational information

Observed issues:
- tables are efficient on desktop but can lose hierarchy in dense views;
- horizontal scroll is necessary on small screens but lacked a clear surface boundary.

Revision:
- table container becomes an explicit bordered surface;
- subtle header background and row hover state;
- mobile minimum width retained so column semantics are not destroyed by forced stacking.

### 10. Responsive design

Audit target breakpoints:
- large desktop: 1440px+
- laptop: 1100–1439px
- tablet: 701–1099px
- mobile: 431–700px
- narrow mobile: 320–430px

Revision rules:
- desktop primary navigation collapses before it becomes crowded;
- two-column public/commerce/auth compositions become single-column intentionally;
- portal sidebar becomes document-flow navigation on tablet/mobile;
- product grid becomes one column on mobile to preserve premium image scale and tap targets;
- tables retain horizontal scrolling rather than compressing data into unreadable cells.

## Accessibility audit

Preserved or strengthened:
- skip navigation;
- semantic headings and landmarks;
- visible `:focus-visible` states;
- labelled navigation;
- `aria-current` portal navigation;
- minimum practical control heights;
- reduced-motion support;
- no color-only selected-state dependency in the portal;
- mobile layouts avoid shrinking table and form text below usable sizes.

Manual acceptance still required:
- keyboard walkthrough of every interactive surface;
- VoiceOver/NVDA screen-reader pass;
- contrast verification against final production images and content;
- 200% zoom/reflow testing;
- real-device touch-target review.

## Performance audit

The revision intentionally adds no frontend framework and no runtime UI dependency. It remains Blade + CSS + the existing progressive-enhancement JavaScript. The modernization layer is static CSS and therefore does not introduce hydration, component-runtime or client-routing overhead.

Production checks should still verify:
- final CSS bundle size;
- image dimensions and formats;
- LCP on image-led hero pages;
- CLS around media and font loading;
- cache policy for compiled assets.

## Implementation status

Implemented in `style/frontend-architecture-modernization`:
- modern cross-surface CSS architecture;
- modern design layer loaded by public and portal layouts;
- modern navigation, controls, heroes, cards, commerce, auth, account and admin surfaces;
- responsive architecture for 1100 / 900 / 700 / 430 breakpoints;
- reduced-motion handling;
- automated architecture guard test.

## Remaining browser acceptance

Code-level modernization does not replace live rendering acceptance. Before production release, test representative pages at 1440, 1024, 768, 430, 390 and 320px, plus Safari/WebKit and Chromium. Confirm product photography crops, long admin table values, validation errors, empty states, pagination, dropdown navigation, mobile menu focus and checkout forms with real approved content.
