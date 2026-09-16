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
