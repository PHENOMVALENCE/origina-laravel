# Next.js → Laravel Migration Map

`PHENOMVALENCE/origina-next` is the frontend source of truth for this migration.

## Rules

- Preserve approved copy, layout, responsive behaviour, navigation and interaction patterns.
- Preserve the institutional-versus-division visual distinction.
- Use the same approved assets locally in Laravel.
- Do not treat migration as a redesign unless a deviation is explicitly approved.
- Do not port Next.js backend/auth/database behaviour during the frontend phase.

## Core mapping

| Next.js | Laravel |
|---|---|
| `src/app/(site)/*` | `resources/views/pages/*` |
| `src/components/*` | `resources/views/components/*` |
| `src/app/globals.css` | `resources/css/app.css` |
| `src/lib/navigation.ts` | `config/origina.php` |
| `src/lib/content/*` | Blade/config content during frontend phase |
| `public/img/*` | `public/img/*` |
| `src/app/favicon.ico` | `public/favicon.ico` |

Backend-only Next.js areas (`src/db`, auth, admin persistence, APIs) are intentionally deferred.

## Current parity status

Implemented Laravel pages:

- `/`
- `/about`
- `/labs`
- `/divisions/b-melanox`

Remaining public Next.js routes are still migration work and must not be described as fully ported while they remain placeholders.

## Assets

Migrated locally from `origina-next`:

- ORIGINA logo and mark;
- favicon;
- founder photography (`founder-01` through `founder-09`);
- current B-Melanox product photography.

Implemented pages must use these local paths rather than GitHub raw URLs.

## Page completion checklist

A route is considered migrated only when:

1. structure and copy match the approved Next.js page;
2. shared header/footer/component behaviour matches;
3. local assets and captions/alt text are correct;
4. desktop and mobile layouts are reviewed;
5. keyboard/focus behaviour is intact;
6. route tests/build checks pass;
7. any deliberate difference is documented.
