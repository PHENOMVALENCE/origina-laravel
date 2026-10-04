# Project Context

ORIGINA™ is being implemented as a Laravel institutional and operational platform.

## Product position

ORIGINA is a science-led, multi-divisional institution built around Biology First™, research, formulation science, evidence, quality, intellectual property and long-term institutional capability.

The public experience must present the institution before commercial expressions. Commerce, accounts and administration support the institution; they must not visually or editorially reduce ORIGINA to a generic storefront or SaaS product.

## Frontend reference relationship

`PHENOMVALENCE/origina-next` remains an approved source for:

- public content and hierarchy;
- scientific/status wording;
- information architecture;
- approved founder, brand and product imagery;
- useful interaction and responsive intent.

The owner has explicitly approved complete Laravel frontend refinement. The Laravel design system is the active visual implementation standard; the Next.js repository is a content and structural reference rather than a pixel-for-pixel target.

## Current Laravel scope

The operational scope activated on 30 September 2026 is current. Earlier frontend-only restrictions are historical and no longer gate implementation.

Current work includes:

- complete institutional and division public pages;
- responsive Blade design system and progressive enhancement;
- catalogue, shopping bag, checkout and order history;
- customer registration, verification, authentication, password reset and profile management;
- administrator dashboards and operational management;
- catalogue, stock, orders, enquiries and publications;
- manufacturing batches, quality-release records, serialized units and public verification;
- versioned API endpoints, Sanctum authentication and protected Swagger/OpenAPI documentation;
- audit history, security headers, private-response controls and production diagnostics;
- accessibility, metadata, sitemap, robots, branded error states, tests, CI and deployment documentation.

## Production-completion phase

The current phase is not a rewrite. It is a completion and hardening phase across the existing Laravel monolith.

Priorities are:

1. refine all public, commerce, authentication, customer and administrator interfaces;
2. close incomplete backend workflows and edge cases;
3. prepare external provider boundaries for online payments and SMS without representing unavailable credentials or subscriptions as live;
4. keep OpenAPI, runtime routes, tests and documentation synchronized;
5. complete accessibility, responsive, security, performance and production-readiness audits;
6. leave deployment-time dependencies explicit and fail-safe.

External services must remain disabled until valid production credentials and business approval exist. Payment success, SMS delivery, regulatory status and scientific outcomes must never be simulated.

## Content rules

Do not invent or strengthen scientific, clinical, regulatory, efficacy, patent, credential or institutional claims.

Future institutions must remain identified as future/planned until established.

See `CONTENT_GOVERNANCE.md`.

## Release boundary

Code readiness and production deployment are separate. The repository can be deployment-ready while real-host acceptance still remains outstanding.

Before launch, the real environment must complete the production checklist for HTTPS/domain configuration, MySQL, SMTP, scheduler, backups/restore, approved catalogue/pricing/claims, delivery/payment configuration, physical traceability labels and final browser/accessibility smoke testing.

Current operational behavior and boundaries are defined primarily by ADR 0002, `ARCHITECTURE.md`, `COMMERCE.md`, `ADMIN_HANDBOOK.md`, `PRODUCTION_CHECKLIST.md` and the current implementation report.
