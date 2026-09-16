# Design System

## Source of truth

During migration, use `PHENOMVALENCE/origina-next` as the approved visual/interaction reference. Reproduce its composition before proposing redesigns.

## Registers

### Institutional

Used for ORIGINA parent-level content: homepage, About, Labs, science, founder, Africa, future, governance and legal pages.

Characteristics:

- warm paper/light surfaces;
- editorial serif + restrained sans-serif hierarchy;
- strong whitespace and hairline rules;
- oxblood/crimson and muted metallic accents;
- documentary photography;
- noir sections used as punctuation, not decoration.

### Division/product

Used for individual divisions and product expressions.

Characteristics:

- can be darker/richer and more sensory;
- remains scientifically disciplined and editorial;
- uses product imagery deliberately;
- avoids generic ecommerce/SaaS visual language.

## Components

Prefer shared Blade primitives for:

- site header/footer;
- page heroes;
- sections and tone variants;
- editorial split layouts;
- buttons/text links;
- division cards;
- image/caption blocks;
- quote bands;
- in-page navigation.

## Rules

- Use semantic CSS tokens rather than arbitrary one-off values.
- Keep spacing and type hierarchy consistent with the Next.js source.
- Preserve responsive behaviour and mobile navigation patterns.
- Use local approved assets with intrinsic dimensions and accurate alt text.
- Avoid unapproved gradients, glassmorphism, excessive shadows, novelty motion and decorative pill UI.
- Any deliberate visual deviation from `origina-next` must be approved and documented.
