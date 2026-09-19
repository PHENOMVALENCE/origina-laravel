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

## Motion and interaction language

ORIGINA motion should feel quiet, confident and continuous. It exists to preserve orientation, reveal hierarchy and make state changes understandable — never to perform for its own sake.

### Interaction principles

- Keep the page scroll native. Do not introduce scroll-jacking, mandatory snap points, fake inertia or parallax tied continuously to scroll position.
- Prefer transform and opacity for animated movement. Avoid layout-changing animation that causes reflow or visible content jumps.
- Use short state transitions for controls and navigation, and slightly slower entrance motion for editorial content.
- Keep movement small: viewport reveals should generally travel no more than 8–18px; image/card scale effects should remain subtle.
- Entrances use the shared ease-out curve; state changes use the shared standard curve; exits should be shorter than entrances.
- Viewport reveals run once and progressively enhance content. Content must remain available if JavaScript or IntersectionObserver is unavailable.
- Sticky navigation should preserve context rather than aggressively hide/reappear while the user scrolls.
- In-page navigation should expose an active section state without forcing the user's scroll position.
- Mobile navigation is modal while open: lock background scroll, keep keyboard focus inside the menu, support Escape, and restore focus when appropriate.
- Hover treatment must have a keyboard-focus equivalent where the interaction is meaningful.
- Honour `prefers-reduced-motion: reduce` by removing non-essential movement and smooth scrolling.

### Performance guardrails

- Do not add an animation framework for effects achievable with CSS, the Web Animations API or IntersectionObserver.
- Continuous scroll work must be minimal and requestAnimationFrame-throttled.
- Avoid animating expensive paint properties, large filters, background-position loops or continuously running decorative effects.
- Motion must remain smooth on mid-range mobile hardware and must not delay reading, navigation or interaction.

## Rules

- Use semantic CSS tokens rather than arbitrary one-off values.
- Keep spacing and type hierarchy consistent with the Next.js source.
- Preserve responsive behaviour and mobile navigation patterns.
- Use local approved assets with intrinsic dimensions and accurate alt text.
- Avoid unapproved gradients, glassmorphism, excessive shadows, novelty motion and decorative pill UI.
- Any deliberate visual deviation from `origina-next` must be approved and documented.
