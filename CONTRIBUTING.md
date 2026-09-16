# Contributing to ORIGINA Laravel

ORIGINA is developed as a production-grade institutional platform. Contributions should preserve scientific credibility, premium visual quality, security, accessibility and long-term maintainability.

## Workflow

1. Sync with `main`.
2. Create a focused branch.
3. Read `AGENTS.md` and the relevant documentation in `docs/`.
4. Implement one coherent concern at a time.
5. Add or update tests and documentation.
6. Run the quality gates.
7. Open a pull request with context, screenshots for UI work, risks and validation results.

## Commit format

Use Conventional Commits, for example:

- `feat: add institutional homepage shell`
- `style: refine editorial type scale`
- `docs: define commerce domain boundaries`
- `fix: restore keyboard navigation in mobile menu`

## Pull-request quality bar

A PR should explain why the change exists, not only what files changed. UI PRs must describe responsive behaviour, accessibility considerations and visual-regression risk. Security-sensitive changes must include threat considerations. Architecture changes require an ADR.

Do not merge failing CI, bypass review, commit secrets, or mix unrelated refactors with feature work.
