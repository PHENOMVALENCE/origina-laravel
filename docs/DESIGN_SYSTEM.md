# ORIGINA Design System

## Design thesis

ORIGINA must communicate two things simultaneously: **scientific/institutional authority** and **premium global brand quality**. The hierarchy is important: credibility first, luxury through restraint rather than ornament.

The parent institution should feel closer to a research institute, scientific journal and enduring cultural institution than to a campaign landing page. Division and product surfaces may become richer and more sensory, but they remain connected to the same evidence-led system.

## Two-register architecture

### Institutional register

Used for institution, science, evidence, labs, founder, Africa, culture, future, legal and parent-level navigation.

Characteristics:
- warm paper/ivory surfaces
- near-black warm ink
- editorial serif headings
- highly readable sans-serif body copy
- hairline rules
- wide whitespace
- documentary photography
- restrained accent usage
- square geometry

### Division/product register

Used for division detail and future commerce/product storytelling.

Characteristics:
- deeper grounds
- division-specific accent colours
- controlled material richness
- larger product photography
- premium spacing and typography
- no reduction in scientific legibility or accessibility

## Foundation tokens

Initial CSS tokens:

| Role | Value | Intent |
|---|---|---|
| Paper | `#fdfbf7` | primary institutional ground |
| Ivory | `#f8f4ec` | secondary light surface / dark-ground text |
| Ink | `#1b1714` | primary text |
| Graphite | `#3a332c` | secondary text |
| Noir | `#161210` | dark institutional/division ground |
| Cream | `#eee6d8` | sunk/light alternate surface |
| Gold | `#b5924a` | premium identity rule/fill; use cautiously |
| Gold readable | `#866a2a` | accessible accent text on light backgrounds |
| Oxblood | `#7a171b` | editorial/scientific emphasis where contrast permits |
| Rule | `rgba(27, 23, 20, .16)` | structural hairline |

Use semantic variables (`--color-surface`, `--color-text`, `--color-accent`) in components rather than hard-coding pigments repeatedly.

## Typography

The current Next.js system evolved toward Source Serif 4 + Source Sans 3 for institutional authority and reading quality. The Laravel frontend should preserve that direction initially.

- display/section headings: Source Serif 4
- body/interface: Source Sans 3
- body text target: ~17px with generous line height
- no interface text below 11px
- comfortable reading measure: ~58–68ch
- display type scales fluidly; do not let headlines overflow 320px viewports

During the prototype phase fonts may load from a web font provider for rapid parity; production should evaluate self-hosting for performance and privacy.

## Composition

- content max width around 1280–1320px
- 12-column desktop thinking, simpler CSS grid implementation
- deliberate asymmetry in editorial hero compositions
- section rhythm larger than conventional SaaS pages
- dark sections are punctuation, not the default parent-site background
- images should have meaningful alt text and captions when captions add context

## Geometry

Default radius: **0**. Rounded UI is permitted only when the object itself has semantic/editorial reason to be circular. Avoid pill buttons, bubbly cards and generic dashboard aesthetics.

Shadows should be rare. Prefer borders, contrast, spacing and layering.

## Motion

Motion is supportive, not theatrical:
- subtle opacity/translate entrance where useful
- short navigation transitions
- respect `prefers-reduced-motion`
- avoid parallax, scroll-jacking, cursor effects and continuous decorative motion

## Accessibility

- target WCAG 2.2 AA contrast
- visible `:focus-visible`
- keyboard-accessible menus
- no colour-only state indication
- semantic headings in logical order
- touch targets approximately 44px minimum for interactive controls
- reduced-motion support

## Photography

Photography should feel documentary, precise and human rather than stock-luxury generic. Existing founder and product photography in `origina-next` remains the visual reference during migration.

Do not hotlink development assets in production. Assets must eventually be copied, optimized, fingerprinted by the build pipeline where appropriate, and served from ORIGINA-controlled infrastructure.

## Anti-patterns

Avoid:
- gradients as decoration
- glassmorphism
- excessive blur
- generic luxury gold-on-black everywhere
- full-site dark mode as a prestige shortcut
- tiny all-caps navigation
- oversized pill UI
- card grids for content that reads better editorially
- unsupported scientific badges or trust marks
- templated ecommerce visuals that detach products from ORIGINA's institutional context
