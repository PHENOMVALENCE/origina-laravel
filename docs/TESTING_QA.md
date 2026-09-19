# Testing & QA

## Automated checks

Run before a PR is ready:

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

Tests should cover public-route rendering, important content contracts and security headers without depending on an unapproved backend.

## Frontend parity review

For each migrated route, compare Laravel against `PHENOMVALENCE/origina-next` at minimum:

- mobile (~375px);
- tablet (~768px);
- desktop (~1440px).

Check:

- content order and copy;
- typography and spacing hierarchy;
- navigation/footer behaviour;
- imagery, crops, captions and alt text;
- interactive states;
- keyboard focus and menu operation;
- overflow, wrapping and layout shifts.

A route is not complete while it is still a placeholder or has an undocumented visual/interaction difference from the approved Next.js implementation.


## Motion and interaction QA

For pages using the shared interaction layer, also verify:

- scrolling remains native and responsive; there is no scroll lock outside an intentionally open modal menu;
- sticky header and in-page navigation do not jump, overlap content or create layout shifts;
- active in-page navigation follows the section in view and remains horizontally reachable on small screens;
- viewport reveals occur once, remain subtle and never delay access to content;
- desktop navigation panels open/close smoothly and remain fully operable by keyboard;
- the mobile navigation traps focus while open, closes with Escape, restores focus appropriately and prevents background scrolling;
- buttons, cards and links provide restrained state feedback without moving surrounding layout;
- `prefers-reduced-motion: reduce` removes non-essential animation and smooth scrolling;
- no interaction depends on hover alone;
- motion remains responsive on a mid-range mobile viewport and does not introduce visible jank.

When browser performance tooling is available, inspect long tasks and layout shifts while scrolling through the longest public routes. Prefer fixes that reduce JavaScript work and preserve compositor-friendly transform/opacity animation.
