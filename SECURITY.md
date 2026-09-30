# Security Policy

## Reporting

Do not disclose suspected vulnerabilities in a public issue. Report them privately to the repository owner or the designated ORIGINA security contact once one is published.

## Baseline

This project targets a defence-in-depth posture suitable for a globally visible institutional and commerce platform. The platform now includes authentication, commerce, administration and personal-data processing. See the implemented controls, operating boundaries and production requirements in the security model.

See `docs/SECURITY_MODEL.md` for the engineering baseline.

## Secrets

- Never commit `.env`, credentials, access tokens, private keys, payment secrets or production database URLs.
- Public client identifiers must still be reviewed before exposure.
- Use environment variables and the deployment platform's secret manager.
- Rotate a secret immediately if it is committed accidentally; removing it from Git history is not sufficient.

## Dependency hygiene

Dependencies should be minimal and maintained. Run Composer and npm security audits before release. Composer audit is included in PHP CI.
