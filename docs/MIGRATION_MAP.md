# Next.js → Laravel Migration Map

`PHENOMVALENCE/origina-next` is an approved source for public content, information architecture and established frontend intent.

The owner has approved a broader Laravel institutional refinement. The Laravel implementation is therefore the active frontend architecture and is not required to reproduce Next.js pixel-for-pixel.

## Mapping

| Next.js | Laravel |
|---|---|
| `src/app/(site)/*` | dedicated Blade views or `config/origina_content.php` + shared renderer |
| `src/components/*` | `resources/views/components/*` + controlled page primitives |
| `src/app/globals.css` | `resources/css/app.css` semantic design system |
| `src/lib/navigation.ts` | `config/origina.php` |
| `src/lib/content/*` | `config/origina_content.php` during frontend phase |
| `public/img/*` | Laravel `public/img/*` referenced via `asset()` |
| metadata helpers | shared Blade layout + sitemap/robots routes |
| Next loading/navigation behavior | lightweight progressive enhancement in `resources/js/app.js` |

Backend-only Next.js concerns such as database access, authentication, admin persistence and APIs remain intentionally deferred.

## Dedicated routes

The following keep bespoke views because their composition is highly specific:

- `/`;
- `/about`;
- `/labs`;
- `/divisions/b-melanox`.

Other approved public routes use the shared institutional content architecture unless a bespoke layout is justified.

## Content migration rule

Preserve approved scientific meaning and status qualifiers. Do not strengthen claims while moving content between frameworks.

Future entities remain future. Research remains research. Proprietary does not become patented. Regulatory alignment does not become approval.

## Visual migration rule

Preserve ORIGINA identity while applying the active Laravel design standard:

- parent institution uses Noir / Ivory / Origin Gold / Graphite / restrained neutrals;
- B-Melanox crimson/oxblood does not become the parent accent;
- individual divisions use scoped semantic themes;
- typography, accessibility and editorial discipline stay shared.

## Assets

Brand, founder and current product media are local. Templates use `asset()`, allowing an optional `ASSET_URL` CDN without changing view code.

## Completion

A migrated route is not complete until its content, responsive layout, accessibility, navigation, assets and tests are reviewed. See `FRONTEND_SCOPE.md` and `TESTING_QA.md`.
