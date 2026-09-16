# Accessibility Standard

Target: WCAG 2.2 AA for public and administrative interfaces.

## Required practices

- one meaningful `h1` per page
- headings follow document structure
- skip link to main content
- landmarks: header/nav/main/footer
- keyboard operability for all interactive controls
- visible focus indicators using `:focus-visible`
- links describe destination or action
- form controls have programmatic labels and useful error text
- image alt text describes relevant content; decorative images use empty alt
- colour is never the only state indicator
- no autoplaying motion/audio
- respect `prefers-reduced-motion`
- touch targets are comfortably operable on mobile
- maintain sufficient contrast in both institutional and division palettes

## QA matrix

At minimum test:
- keyboard only
- 200% browser zoom
- narrow viewport (~320px)
- system reduced motion
- light/dark OS preference even if the site does not implement dark mode
- browser accessibility tree/landmark inspection
- automated accessibility scan as a supplement, not a substitute for manual checks
