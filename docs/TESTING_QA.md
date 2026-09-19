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

Automated coverage should verify:

- dedicated public routes;
- every config-backed institutional route;
- every config-backed division route;
- every future horizon route;
- absence of the old placeholder copy;
- required content metadata;
- sitemap;
- environment-aware robots;
- branded 404;
- security headers.

## Browser matrix

Review at minimum:

- narrow mobile: 320–375px;
- tablet: ~768px;
- desktop: ~1440px.

Use at least one Chromium-based browser and, where practical, Safari/WebKit behavior for mobile-sensitive interactions.

## Visual/content review

Check:

- institutional versus division color register;
- title/heading hierarchy;
- body measure and spacing rhythm;
- content status wording;
- navigation/footer behavior;
- imagery, crops, captions and alt text;
- legal/contact empty states;
- custom errors;
- overflow and wrapping;
- layout shift while images load.

## Interaction QA

Verify:

- scrolling remains native;
- no background scroll while mobile navigation is open;
- mobile focus stays within the modal menu;
- Escape closes open navigation;
- desktop navigation works by keyboard;
- sticky header/section navigation do not overlap content;
- active section state follows the page;
- internal navigation progress never blocks interaction;
- viewport reveals are subtle and one-time;
- no interaction requires hover;
- reduced-motion removes non-essential animation/smooth scrolling.

## Accessibility QA

Review:

- landmarks and heading order;
- visible focus;
- touch-target practicality;
- contrast on every institutional/division ground;
- alternative text;
- color-independent meaning;
- keyboard-only completion of all public interactions;
- zoom/reflow at 200%.

## Asset/performance QA

Inspect:

- no GitHub/raw hotlinks;
- correct `ASSET_URL` behavior where configured;
- no missing favicon/CSS/JS/images;
- hero image priority;
- lazy below-the-fold imagery;
- long tasks while scrolling;
- cumulative layout shift;
- avoidable third-party requests.

## Release QA

Before production promotion, additionally verify:

- `APP_DEBUG=false`;
- canonical `APP_URL`;
- production robots allows intended crawling;
- sitemap uses canonical host;
- HTTPS;
- health endpoint;
- 404/500/503 presentation;
- logging/monitoring/rollback ownership.

Do not claim browser, performance or accessibility review has passed unless it was actually performed.
