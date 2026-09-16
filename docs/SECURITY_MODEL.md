# Security Model

## Current phase

The application is frontend-first and does not yet include persistence, authentication, APIs, payments or admin workflows.

Current protections should include:

- Laravel output escaping and CSRF defaults;
- secure session/cookie configuration;
- explicit security headers;
- no secrets in source control;
- conservative third-party script usage;
- dependency and CI checks.

## Future backend requirements

Before adding user data, admin access, APIs or commerce, define and review:

- authentication and authorization model;
- validation and rate limiting;
- data classification and retention;
- audit logging;
- secret/key management;
- payment-provider boundaries;
- file-upload controls;
- backup/recovery procedures;
- abuse/fraud controls where applicable.

Security-sensitive architecture changes require explicit review and, when durable, an ADR.
