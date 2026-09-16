# Security Policy

## Reporting

Do not disclose suspected vulnerabilities in a public issue. Report them privately to the repository owner or the designated ORIGINA security contact once one is published.

## Baseline

This project targets a defence-in-depth posture suitable for a globally visible institutional and commerce platform. The frontend-only phase deliberately minimizes attack surface, while the architecture reserves controls for future authentication, commerce, payments, administration and personal-data processing.

See `docs/SECURITY_MODEL.md` for the engineering baseline.

## Secrets

- Never commit `.env`, credentials, access tokens, private keys, payment secrets or production database URLs.
- Public client identifiers must still be reviewed before exposure.
- Use environment variables and the deployment platform's secret manager.
- Rotate a secret immediately if it is committed accidentally; removing it from Git history is not sufficient.

## Dependency hygiene

Dependencies should be minimal and maintained. CI should run Composer and npm security audits when the project reaches deployment readiness.
