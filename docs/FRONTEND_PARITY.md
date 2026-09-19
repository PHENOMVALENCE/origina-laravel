# Frontend Completion Audit

Reference content/structure: `PHENOMVALENCE/origina-next` `main`.

The Laravel frontend is allowed to deliberately refine presentation and interaction under the approved institutional design mandate. “Parity” therefore means preserved approved meaning, information architecture and assets where applicable — not pixel matching.

## Shared shell

- [x] local ORIGINA brand assets;
- [x] desktop navigation and grouped information architecture;
- [x] full-screen mobile navigation with focus containment, Escape handling and scroll lock;
- [x] institution/division visual layers;
- [x] complete footer and legal/governance navigation;
- [x] native-scroll interaction layer and reduced-motion support;
- [x] canonical/OG/Twitter metadata shell;
- [x] sitemap and robots endpoints;
- [x] branded 404/500/503 views;
- [x] CDN-ready asset boundary;
- [ ] final in-browser review at target breakpoints.

## Route implementation status

| Surface | Implementation |
|---|---|
| Home, About, Labs | dedicated Laravel views |
| B-Melanox | dedicated division view |
| Founder, Africa, Biology First, Culture | content-driven institutional renderer |
| Science, Platforms, Evidence, Regulatory, Quality, Responsible Science | content-driven institutional renderer |
| Intellectual Property, Divisions index | content-driven institutional renderer |
| BettyWorld, BValence, DIVINE, NOVIA, Skin Safari | content-driven division renderer |
| Future index and all future horizon pages | content-driven institutional renderer |
| Contact, Updates, Privacy, Terms | content-driven institutional/legal renderer |

No approved public route is intentionally routed to the old placeholder view.

## Remaining review work

Before declaring the frontend fully complete:

- [ ] browser review around 320/375px mobile;
- [ ] tablet review around 768px;
- [ ] desktop review around 1440px;
- [ ] contrast and keyboard review across light and dark registers;
- [ ] image crop/quality review;
- [ ] longest-page scroll/performance review;
- [ ] final CI on the frontend-completion head.

## Assets

Approved media remains repository-managed and must be referenced through Laravel's asset boundary. Production views must not hotlink GitHub assets.

See `ASSET_DELIVERY.md`.

## Exit condition

Frontend completion requires real public pages, coherent institutional design, green quality gates and final responsive/accessibility review. Backend work remains gated separately.
