# ORIGINA™ Design System

## Design objective

ORIGINA should feel like a serious scientific institution with premium execution — not a generic cosmetics store, SaaS product or luxury template.

The active design contract is the Laravel implementation plus this document. `PHENOMVALENCE/origina-next` remains an approved content/structure reference.

## Institutional palette

Parent-level pages use a restrained semantic system:

| Role | Value | Use |
|---|---|---|
| Origina Noir | `#161210` | highest emphasis, primary action, dark bands |
| Institution Ivory | `#f8f4ec` | light contrast and dark-ground text |
| Origin Gold | `#b5924a` | rules, fills, selected states, institutional thread |
| Readable Gold | `#866a2a` | AA-oriented accent text on light ground |
| Warm Graphite | `#3a332c` | body/supporting text |
| Paper | `#fdfbf7` | primary institutional canvas |

Origin Gold is an identity mark, not ordinary small body text.

Oxblood/crimson is not the parent institution's default accent. It is principally associated with B-Melanox and semantic error contexts.

## Division registers

Individual division pages scope semantic tokens rather than rewriting shared components.

Current direction:

- B-Melanox — warm charcoal, readable pigment-red accent, oxblood action;
- BettyWorld — deep ink, antique gold;
- NOVIA — forest noir, deep sage, warm gold/cream;
- DIVINE — midnight ground, sovereign gold, imperial burgundy;
- BValence / Skin Safari — neutral ORIGINA dark register until a confirmed division palette exists.

Every division still shares ORIGINA typography, layout, interaction, focus behavior and editorial standards.

## Typography

- **Source Serif 4** — institutional headlines, propositions, quotations, display statements.
- **Source Sans 3** — body copy, navigation, metadata, controls, captions and tables.

Body copy remains sans-serif. Display type uses responsive `clamp()` sizing and controlled line length.

## Geometry and hierarchy

- radius: 0 as a system rule;
- elevation: none as a hierarchy rule;
- hierarchy is created by type, whitespace, surface changes and hairline rules;
- content container follows a disciplined editorial grid;
- section spacing uses shared tokens;
- long prose is measure-limited for reading comfort.

## Imagery

Photography is structural evidence, not decoration.

Approved structural ratios:

- 16:9 cinematic;
- 4:3 editorial;
- 3:4 portrait;
- 3:2 feature;
- 1:1 square.

Every meaningful image needs accurate alt text and, when context matters, a caption. Use intrinsic dimensions. Hero imagery may be eager/high priority; below-the-fold media should be lazy.

See `ASSET_DELIVERY.md`.

## Editorial primitives

Prefer shared primitives for:

- site header/footer;
- page hero;
- section and tone variants;
- in-page section navigation;
- split editorial sections;
- institutional cards;
- numbered sequences;
- detail/evidence lists;
- institutional directories;
- quotes/statements;
- legal prose;
- contact/empty states;
- managed media;
- closing CTA.

New layouts should reuse these before adding another pattern.

## Motion and interaction

ORIGINA motion should feel quiet, confident and continuous.

- native scrolling only;
- no scroll-jacking, fake inertia, forced snap or parallax;
- small transform/opacity entrances only where hierarchy benefits;
- short control/navigation transitions;
- viewport reveals run once;
- sticky navigation preserves orientation;
- mobile navigation is modal, keyboard-contained and Escape-closeable;
- no information depends on hover alone;
- `prefers-reduced-motion: reduce` removes non-essential movement and smooth scrolling.

Do not add an animation framework for effects achievable with CSS, Web Animations API or IntersectionObserver.

## Loading

Do not use a blocking splash screen.

Use server-rendered content, intrinsic media dimensions, subtle media placeholders and a lightweight top navigation progress signal. Content must remain available if JavaScript fails.

## Accessibility

Target WCAG 2.2 AA.

Required:

- semantic landmarks and logical headings;
- one meaningful page `h1`;
- visible focus;
- keyboard operation;
- sufficient contrast;
- ≥44px practical touch targets where appropriate;
- meaningful alternative text;
- reduced-motion support;
- no color-only communication;
- responsive layouts without unintended horizontal overflow.

Accessibility outranks exact visual parity with older references.

## Decision order

When design goals conflict:

1. ORIGINA brand identity;
2. institutional credibility;
3. scientific/content integrity;
4. user comprehension;
5. accessibility;
6. responsive usability;
7. performance;
8. visual sophistication;
9. decorative novelty.

If something looks interesting but weakens credibility, comprehension or evidence discipline, remove it.
