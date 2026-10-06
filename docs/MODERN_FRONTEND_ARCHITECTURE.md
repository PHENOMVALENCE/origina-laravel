# ORIGINA Modern Frontend Architecture

## Purpose

This document defines the active presentation architecture for ORIGINA's Laravel application. It applies to public institutional pages, division pages, commerce, authentication, customer account and administrator operations.

The objective is not to turn ORIGINA into a generic SaaS interface. The system should remain science-led, editorial and institution-first while using modern interaction, spacing, responsive and operational UI standards.

## Layering model

The frontend currently uses a transitional layered architecture:

1. `resources/css/app.css` — original institutional tokens and components.
2. `resources/css/platform.css` — operational/commerce/auth extensions imported by `app.css`.
3. existing static refinement stylesheets — legacy compatibility and prior production refinements.
4. `resources/css/modern.css` — final cross-surface convergence layer.

`modern.css` is intentionally loaded last. New visual architecture work should prefer this layer until older selectors are consolidated and retired. Do not add another page-wide refinement stylesheet.

## Design principles

### Institutional before ornamental

ORIGINA should communicate credibility, scientific seriousness and restraint before visual novelty. Motion, blur, depth and rounded geometry are supporting devices, not the identity itself.

### One system across every surface

Public pages, shopping, authentication and operations should clearly belong to the same institution. They can vary in density, but typography, controls, borders, surfaces, spacing and state behavior must remain related.

### Content hierarchy over decoration

Use large display serif typography selectively. Dense admin screens should prioritize scanability. Commerce should prioritize product imagery, product status, price and next action. Scientific/institutional pages should prioritize evidence, explanation and traceable structure.

### Progressive enhancement

Blade-rendered content must remain useful without client-side JavaScript. JavaScript improves navigation and interaction but must not own core content or application state presentation.

## Core tokens

The modern layer defines:

- canvas and elevated surfaces;
- primary and muted text;
- subtle and strong rules;
- institutional gold accent;
- small/standard/large radius scales;
- low and elevated shadow scales;
- maximum content width;
- global section rhythm.

Use tokens rather than introducing arbitrary page-specific values where an existing token is suitable.

## Geometry

The historical interface used near-square geometry. The modern system introduces restrained rounding:

- compact controls: approximately 10–13px;
- standard cards: approximately 16px;
- large image/hero frames: approximately 22px;
- primary navigation/action pills: full radius.

This should remain restrained. Avoid oversized bubble UI or excessive card nesting.

## Navigation architecture

### Desktop

- sticky translucent header;
- brand at left;
- primary institutional navigation centered when space allows;
- commerce/account actions at right;
- active and hover states use background/surface feedback rather than only an underline;
- collapse primary navigation before links become crowded.

### Mobile

- brand + one menu trigger in the fixed shell;
- commerce actions move into the navigation document;
- menu groups retain semantic headings;
- keyboard escape/focus behavior from the existing JavaScript remains mandatory.

## Public page structure

Recommended public page sequence:

1. hero / thesis;
2. context or institutional framing;
3. evidence, capability or explanation modules;
4. related division/product/research paths;
5. appropriate enquiry or next action.

Avoid forcing every page into identical cards. Editorial split layouts, full-width statements, evidence lists and media-led sections are valid when they follow the shared rhythm.

## Commerce architecture

### Collection

- generous introductory hero;
- filtering/status controls separated from the product grid;
- image-first product cards;
- title, category/eyebrow, price and availability hierarchy kept concise.

### Product detail

- media and buying information use a balanced two-column layout on large screens;
- mobile stacks media before commerce controls;
- product claims and disclosures remain separate from the buying action;
- inventory/payment state must not be implied visually unless supported by backend state.

### Bag and checkout

- primary task column + summary column on large screens;
- summary becomes normal-flow on smaller screens;
- totals and next action must be immediately scannable;
- form fields preserve labels, validation messages and minimum touch height.

## Authentication architecture

Use a two-part composition where space permits:

- institutional/scientific story panel;
- focused authentication form panel.

The form must not become decorative. Error feedback, password reset and verification actions remain the priority.

## Portal architecture

### Sidebar

- dark institutional workspace navigation;
- active state uses both surface and boundary treatment;
- customer/admin context is identified clearly;
- destructive/sign-out actions remain visually separated from primary navigation.

### Top bar

- sticky on larger screens;
- workspace context + signed-in identity;
- does not compete with the page heading.

### Main content

Use, in order where applicable:

1. eyebrow/workspace context;
2. page heading and concise subtitle;
3. primary actions;
4. feedback/validation;
5. stats/summary;
6. operational panels or tables.

### Statistics

Use independent cards instead of a single contiguous grid boundary. Every statistic must have a label and a readable value; color alone cannot convey meaning.

### Tables

Keep semantic HTML tables for dense operational data. On narrow screens, allow horizontal scrolling rather than converting unrelated columns into ambiguous stacked blocks.

## Forms

- explicit labels remain mandatory;
- controls target at least ~48px height;
- visible focus halo is mandatory;
- placeholder text cannot replace labels;
- validation messages remain adjacent to the affected control;
- dangerous/destructive actions should not use the primary-action visual treatment without confirmation.

## Responsive acceptance matrix

Every major surface must be checked at minimum at:

- 1440px desktop;
- 1024px laptop/tablet landscape;
- 768px tablet portrait;
- 430px large phone;
- 390px common phone;
- 320px narrow phone.

For pages containing operational tables, additionally verify horizontal scrolling and sticky/overflow behavior.

## Accessibility requirements

Baseline:

- WCAG 2.2 AA target;
- semantic landmarks;
- one meaningful primary heading per release page;
- skip link;
- keyboard-reachable controls;
- visible focus treatment;
- reduced-motion support;
- labels/instructions for form controls;
- state must not depend on color alone;
- mobile reflow and 200% zoom acceptance.

## Performance requirements

- avoid introducing a client UI framework solely for styling;
- keep page rendering server-first;
- prefer CSS over JavaScript for layout/animation;
- size images to their rendered use;
- avoid autoplay video in critical content paths;
- motion must use transform/opacity where possible;
- audit LCP/CLS after final production content and images are loaded.

## Future consolidation

After this modernization is accepted in production, the next CSS maintenance step should consolidate duplicated rules from `app.css`, `platform.css`, `production-refinement.css` and `portal-refinement.css` into a smaller explicit component architecture. That cleanup should be behavior-preserving and undertaken separately from the visual redesign to keep regression review tractable.
