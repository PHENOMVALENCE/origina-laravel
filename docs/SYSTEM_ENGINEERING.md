# System Engineering Standard

## Quality attributes

ORIGINA should be engineered against explicit non-functional requirements from the start.

### Security

- least privilege
- secure defaults
- strict input validation
- context-aware output escaping
- CSRF protection
- robust authorization boundaries
- auditable administrative actions
- dependency and secret hygiene

### Availability and resilience

Future state-changing operations must fail safely. Payment, order and webhook processing will require retries, idempotency and observable failure states rather than silent partial success.

### Performance

Public pages should remain lightweight and cache-friendly. Establish budgets before commerce scripts accumulate:

- LCP target: <= 2.5s at the 75th percentile
- CLS target: <= 0.1
- INP target: <= 200ms
- avoid render-blocking third-party scripts
- responsive images with explicit dimensions
- minimal JavaScript on institutional pages

Targets are goals to validate in production telemetry, not claims that the current build already achieves them.

### Accessibility

WCAG 2.2 AA is the minimum target. Accessibility is part of definition-of-done, not a final audit phase.

### Maintainability

Prefer boring, explicit architecture over clever abstraction. Every abstraction should remove meaningful duplication or enforce a real boundary.

### Observability

Future production work should include structured logs, request correlation where relevant, error tracking, uptime monitoring and operational dashboards. Never log passwords, tokens, payment credentials or unnecessarily sensitive personal data.

## Environments

Plan for at least:

- local development
- CI/test
- staging/preview
- production

Production configuration must not be inferred from local defaults.

## Configuration principles

- environment-specific values live outside version control
- feature flags are explicit
- fail closed on security-critical configuration
- production disables debug output
- cookies use secure and httpOnly flags where applicable
- trusted proxy/host configuration is deliberate

## Change management

Significant changes move through:

1. requirement/context
2. architecture or ADR if needed
3. implementation
4. automated validation
5. visual/functional QA
6. review
7. controlled release
8. monitoring

## Data engineering — future phase

Before adding persistence, create a data-classification document covering public, internal, personal, sensitive and financial data. Define retention, deletion, backup and audit requirements before tables proliferate.

## Payment engineering — future phase

Never store raw card data. Use hosted/tokenized payment mechanisms from compliant providers. Webhooks require signature verification, replay protection/idempotency and reconciliation against provider state.
