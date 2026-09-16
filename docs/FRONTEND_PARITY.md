# Frontend Parity Audit

Reference: `PHENOMVALENCE/origina-next` `main`.

A route is **complete** only when the Laravel implementation matches the approved Next.js structure, copy, responsive behaviour, interactions and assets, and has passed applicable QA.

## Current status

| Route | Status |
|---|---|
| `/` | Implemented; parity reviewed structurally; local assets |
| `/about` | Implemented; parity review required in browser |
| `/labs` | Implemented; parity review required in browser |
| `/divisions/b-melanox` | Implemented; local product assets; parity review required in browser |
| `/founder` | Placeholder |
| `/africa` | Placeholder |
| `/biology-first` | Placeholder |
| `/culture` | Placeholder |
| `/science` | Placeholder |
| `/platforms` | Placeholder |
| `/science/evidence` | Placeholder |
| `/science/regulatory` | Placeholder |
| `/science/quality` | Placeholder |
| `/science/responsible-science` | Placeholder |
| `/intellectual-property` | Placeholder |
| `/divisions` | Placeholder |
| `/divisions/bettyworld` | Placeholder |
| `/divisions/bvalence` | Placeholder |
| `/divisions/divine` | Placeholder |
| `/divisions/novia` | Placeholder |
| `/divisions/skin-safari` | Placeholder |
| `/future` | Placeholder |
| `/future/*` | Placeholder |
| `/contact` | Placeholder |
| `/updates` | Placeholder |
| `/privacy` | Placeholder |
| `/terms` | Placeholder |

## Shared UI review

Every page migration must verify:

- header structure, desktop navigation and mobile menu;
- footer content/link architecture;
- typography families, weights, line-height and scale;
- paper/noir/sunk tones and design tokens;
- page/section spacing and max widths;
- image crops, captions and intrinsic dimensions;
- buttons, text links, hover/focus states;
- reduced-motion behaviour;
- section navigation where present;
- responsive stacking and overflow.

## Asset parity

Copied locally from the Next.js repository:

- `public/img/brand/origina-logo.png`
- `public/img/brand/origina-mark.png`
- `public/favicon.ico`
- `public/img/founder/founder-01.jpeg` through `founder-09.jpeg`
- B-Melanox product images currently present in `origina-next/public/img/products/`

Production views must not hotlink these assets from GitHub.

## Exit condition

The frontend migration is not complete while any approved public route remains a placeholder or any implemented route has an unresolved parity difference.
