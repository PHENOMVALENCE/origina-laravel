# Testing and QA

## Testing pyramid for the current phase

### PHP / Laravel

- feature tests assert public routes render successfully
- component/view tests cover critical reusable Blade output where useful
- architecture tests can be added when backend namespaces exist

### Frontend

- production Vite build must succeed
- linting/formatting for CSS/JS can be introduced if complexity grows
- manual responsive QA at 320, 375/390, 768, 1024, 1280 and 1440+ widths
- keyboard navigation
- reduced-motion behaviour
- basic cross-browser checks on current Chrome/Edge, Firefox and Safari

## Visual QA checklist

- typography loads without destructive layout shift
- hero does not overflow
- long headings wrap intentionally
- images crop appropriately
- body line length remains readable
- dark/light section boundaries are deliberate
- footer and navigation remain usable at all widths
- no horizontal scroll at 320px

## Quality gates

Planned commands:

```bash
composer test
composer analyse
composer lint:test
npm ci
npm run build
```

CI results are evidence only for checks that actually run. Manual visual QA should be documented in the PR.
