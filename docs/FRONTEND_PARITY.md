# Frontend Parity Audit

Reference: `PHENOMVALENCE/origina-next` `main`.

A route is **complete** only when the Laravel implementation matches the approved Next.js structure, copy, responsive behaviour, interactions and assets, and has passed applicable QA.

## Shared shell

- [x] ORIGINA mark/logo assets are local.
- [x] Desktop primary navigation and dropdown groups mirror the Next.js information architecture.
- [x] Mobile navigation uses grouped links, full-screen presentation, Escape handling and scroll lock.
- [x] Division routes retain the dark header register.
- [x] Footer groups and legal/governance links mirror the Next.js navigation registry.
- [x] Favicon is local.
- [ ] Final in-browser visual comparison at target breakpoints.

## Current route status

| Route | Status |
|---|---|
| `/` | Implemented; structural parity reviewed; local assets |
| `/about` | Implemented; final browser parity review pending |
| `/labs` | Implemented; final browser parity review pending |
| `/divisions/b-melanox` | Implemented; local product assets; final browser parity review pending |
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

## Page review checklist

Every migrated page must verify:

- content order and approved copy;
- typography and spacing hierarchy;
- image crops, captions and alt text;
- buttons, links and interactive states;
- keyboard/focus behaviour;
- reduced-motion behaviour;
- responsive stacking and overflow;
- route-specific section navigation where present.

## Asset parity

Copied locally from the Next.js repository:

- `public/img/brand/origina-logo.png`
- `public/img/brand/origina-mark.png`
- `public/favicon.ico`
- `public/img/founder/founder-01.jpeg` through `founder-09.jpeg`
- all B-Melanox images currently present in `origina-next/public/img/products/`

Production views must not hotlink these assets from GitHub.

## Exit condition

The frontend migration is not complete while any approved public route remains a placeholder or any implemented route has an unresolved parity difference.
