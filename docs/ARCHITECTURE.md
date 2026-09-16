# Architecture

## Architectural objective

Build ORIGINA as a maintainable Laravel monolith with clear domain boundaries, server-rendered public pages, a deliberately small frontend runtime and a path to secure commerce and administration later.

The monolith is a deployment boundary, not permission to mix concerns.

## Current stack

| Layer | Choice |
|---|---|
| Runtime | PHP 8.3+ |
| Framework | Laravel 12 |
| Rendering | Blade, server-rendered |
| Asset pipeline | Vite |
| Styling | Project CSS with semantic custom properties |
| JavaScript | Vanilla ES modules / progressive enhancement |
| Tests | PHPUnit + Laravel testing utilities |
| Static analysis | Larastan / PHPStan |
| Formatting | Laravel Pint |
| CI | GitHub Actions |

No database technology is selected for the current frontend-only phase. A future ADR will select persistence when backend implementation begins.

## Target repository layout

```text
app/
  Http/
  Providers/
bootstrap/
config/
public/
resources/
  css/
  js/
  views/
    components/
    layouts/
    pages/
routes/
storage/
tests/
docs/
  adr/
.github/
```

## View architecture

Use Blade composition rather than duplicated page markup.

- `layouts/site.blade.php` — document shell, metadata, skip link, header/footer, Vite entrypoints.
- `components/site-header.blade.php` — global navigation.
- `components/site-footer.blade.php` — institutional footer.
- `components/section.blade.php` — repeated section framing.
- `components/button.blade.php` — actions with consistent semantics.
- page views contain page-specific composition and approved copy only.

Avoid database calls, HTTP calls and business rules in Blade.

## Future domain boundaries

When backend work is approved, preserve explicit modules/concepts even if they initially live in one Laravel app:

- **Institutional Content** — pages, publications, scientific evidence, governance content.
- **Catalogue** — products, variants, collections, division ownership, scientific/product dossiers.
- **Commerce** — cart, checkout, pricing, promotions and order orchestration.
- **Payments** — provider adapters, payment intents, webhooks, reconciliation and idempotency.
- **Orders & Fulfilment** — order lifecycle, delivery, shipment status and returns.
- **Identity** — customers, staff, authentication, authorization and consent.
- **CRM / Enquiries** — institutional and commercial enquiries.
- **Administration** — controlled editorial and operations workflows.
- **Audit & Observability** — security events, change history, system telemetry.

These boundaries must not be implemented prematurely in the frontend phase.

## Rendering strategy

Prefer server-side Blade rendering for content pages because it provides:

- minimal client JavaScript
- predictable SEO
- stable accessibility
- simpler security boundaries
- excellent initial rendering performance

Use client-side JavaScript only for behaviour that genuinely benefits from it, such as navigation disclosure, filters or future cart interactions.

## URL architecture

Preserve stable, descriptive URLs where possible. Initial public route families should align with the current ORIGINA information architecture:

`/`, `/about`, `/founder`, `/africa`, `/biology-first`, `/science`, `/labs`, `/science/evidence`, `/science/quality`, `/science/regulatory`, `/science/responsible-science`, `/intellectual-property`, `/divisions`, division detail routes, `/future`, `/contact`, `/updates`, `/privacy`, `/terms`.

Commerce routes will be designed separately before implementation; do not overload institutional routes with storefront assumptions.

## Architecture rules

1. Controllers coordinate; they do not become domain objects.
2. Validation belongs in Form Requests once forms exist.
3. Authorization uses policies/gates; role checks are not scattered through templates.
4. External providers sit behind interfaces/adapters.
5. Payment and webhook handlers must be idempotent.
6. Models do not contain view formatting concerns.
7. No business logic in Blade.
8. No global helper sprawl.
9. Any durable deviation requires an ADR.
