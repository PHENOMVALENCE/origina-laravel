# Contributing

## Before implementation

1. Read `AGENTS.md`.
2. Confirm the intended parent branch.
3. For UI work, inspect the matching `PHENOMVALENCE/origina-next` route and shared components.
4. Create a focused work branch.

## Implementation

- Preserve approved ORIGINA copy and scientific caution.
- Mirror the Next.js UI/UX during migration unless a deviation is approved.
- Reuse local approved assets; do not hotlink source-repository images.
- Keep changes small and coherent.
- Add/update tests and documentation only where the change requires it.

## Git attribution

All commits and PR implementation history belong to the human maintainer.

Do not add agent, AI, bot or assistant authorship, `Co-authored-by` trailers, changelog credit or PR implementation credit.

Use Conventional Commits, for example:

```text
feat: mirror next labs page
fix: align mobile navigation spacing
docs: update migration status
assets: migrate founder photography
```

## Before opening a PR

Run the applicable checks:

```bash
composer validate --strict
composer lint:test
composer analyse
composer test
npm run build
```

For visual changes, compare desktop and mobile behaviour against `origina-next` and document any approved difference.
