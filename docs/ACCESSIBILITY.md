# Accessibility

Target: **WCAG 2.2 AA**.

Accessibility is part of the design system, not a post-release patch.

## Required public behavior

- semantic `header`, `nav`, `main`, `footer` landmarks;
- logical heading hierarchy and meaningful page `h1`;
- keyboard-operable navigation and controls;
- visible focus states;
- practical touch targets;
- meaningful alt text/captions;
- sufficient contrast in both institutional and division registers;
- no meaning communicated by color alone;
- reduced-motion support;
- responsive reflow without unintended horizontal overflow;
- skip link to main content.

## Navigation

Desktop dropdown panels must expose `aria-expanded` state and close predictably.

Mobile navigation behaves as a modal surface while open:

- background scroll is locked;
- focus moves into the menu;
- Tab/Shift+Tab remain within the focusable menu controls;
- Escape closes the menu;
- focus is restored appropriately.

## Motion

`prefers-reduced-motion: reduce` disables non-essential animation and smooth scrolling.

Content must not remain hidden if JavaScript or IntersectionObserver fails.

## Color

Brand identity never overrides contrast.

Origin Gold is not ordinary small text on light paper. The frontend uses a darker readable gold role where accent text is needed on light surfaces.

Division palettes must be checked independently because the same component can render against different grounds.

## Images

Decorative brand marks use empty alt text. Meaningful founder/product/editorial imagery uses accurate descriptive alt text.

Captions should add context rather than repeat alt text.

## Forms

Current frontend does not provide a backend enquiry form. When forms are introduced they must include:

- programmatic labels;
- clear required/optional status;
- associated error messages;
- instructions;
- keyboard-safe validation;
- no reliance on placeholder text as a label.

General enquiry forms must not solicit sensitive health/research participant data.

## Review

Parity with older references never overrides accessibility. Preserve the intended identity while fixing accessibility defects and document meaningful deviations.
