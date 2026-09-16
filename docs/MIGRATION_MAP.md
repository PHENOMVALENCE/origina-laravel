# Next.js → Laravel Migration Map

This file maps the existing `PHENOMVALENCE/origina-next` structure into the Laravel implementation so the re-platforming preserves intent rather than mechanically translating syntax.

## Source principles being carried forward

The Next.js implementation established several durable ideas that remain valid in Laravel:

- institutional parent layer versus richer division/product layer
- editorial, evidence-led homepage rather than a conventional ecommerce landing page
- Source Serif 4 + Source Sans 3 direction
- warm-paper institutional surfaces, noir punctuation bands, restrained gold and oxblood accents
- documentary founder/product photography
- WCAG-conscious contrast decisions
- conservative scientific claims
- shared navigation, footer, hero and section primitives
- server-rendered public content as the default

## Structural mapping

| Next.js source | Laravel destination | Migration intent |
|---|---|---|
| `src/app/(site)/page.tsx` | `resources/views/pages/home.blade.php` | Homepage composition and approved copy |
| `src/components/HomeHero.tsx` | homepage hero section / future `components/home-hero.blade.php` | Preserve editorial split, single documentary image and calm motion |
| `src/components/SiteHeader.tsx` | `resources/views/components/site-header.blade.php` | Global navigation, responsive menu and accessibility |
| `src/components/SiteFooter.tsx` | `resources/views/components/site-footer.blade.php` | Institutional link architecture and closing positioning |
| `src/components/Section.tsx` | `resources/views/components/section.blade.php` | Tone-based section shell |
| `src/components/ui/Button.tsx` | `resources/views/components/button.blade.php` | Shared action styling |
| `src/lib/navigation.ts` | `config/origina.php` initially | Static navigation registry until a content backend is approved |
| `src/lib/content/*` | Blade/config/content layer to be designed in Phase 2 | Port approved content without inventing claims |
| `src/app/globals.css` | `resources/css/app.css` | Semantic design tokens and component grammar |
| `src/lib/metadata.ts` | Blade layout + future metadata service | Canonical, social and structured metadata once production domains are confirmed |
| `src/db/*`, Drizzle migrations | **not migrated yet** | Backend gate required |
| `src/app/admin/*` | **not migrated yet** | Identity/admin architecture must be approved first |
| `src/lib/auth/*` | **not migrated yet** | Use Laravel-native auth/authorization design in backend phase |

## Route migration

The Laravel foundation prepares the public route families currently represented by the Next.js project:

- `/`
- `/about`
- `/founder`
- `/africa`
- `/biology-first`
- `/culture`
- `/science`
- `/labs`
- `/platforms`
- `/science/evidence`
- `/science/regulatory`
- `/science/quality`
- `/science/responsible-science`
- `/intellectual-property`
- `/divisions` and division detail routes
- `/future` and future initiative routes
- `/contact`
- `/updates`
- `/privacy`
- `/terms`

Only the homepage is currently treated as a real visual prototype. The other routes are placeholders so the information architecture and navigation can be reviewed without prematurely porting every page.

## Asset migration

Current homepage prototype imagery temporarily references the existing repository's raw GitHub assets. Production migration must:

1. copy only approved assets into this repository or an ORIGINA-owned asset service;
2. preserve verified alt text and captions;
3. generate responsive sizes/formats;
4. set intrinsic dimensions to protect CLS;
5. avoid hotlinking GitHub in production;
6. document licensing/ownership for any new third-party photography.

## Content migration rule

A copy change during migration is not automatically a "design improvement." Changes to scientific, clinical, regulatory, founder, platform or product claims require owner/scientific approval. When uncertain, preserve the existing approved wording and record the question instead of rewriting it.

## Frontend completion criteria

Before backend implementation starts, the public Laravel layer should have:

- all approved institutional pages ported;
- no broken/placeholder navigation on the review environment;
- final local/managed assets;
- responsive QA;
- accessibility QA;
- metadata and canonical-domain plan;
- production CSP design after third-party asset/font decisions;
- committed dependency lockfiles;
- passing CI.
