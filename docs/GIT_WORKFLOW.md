# Git Workflow

## Branch model

- `main` — accepted/release baseline; changes arrive through PRs.
- `masterchanges` — current integration branch.
- work branches — `feature/*`, `fix/*`, `docs/*`, `refactor/*`, `chore/*`.

Keep work branches short-lived and based on the latest intended parent branch.

## Human ownership

Repository history must represent the human maintainer, not the tools used to assist implementation.

- Commit and push through the maintainer's connected GitHub account.
- Preserve the maintainer's configured author and committer identity.
- Do not add AI/agent/bot authors, `Co-authored-by` trailers, assistant credits or implementation attribution.
- Do not create automated credit lines in PRs, changelogs or documentation.

## Commits

Use Conventional Commits and one logical concern per commit.

Examples:

```text
docs: tighten repository contribution rules
assets: migrate approved brand imagery
feat: mirror next about page
fix: align mobile navigation behaviour
```

Small commits are preferred over broad mixed changes.

## Pull requests

A PR should state:

- what changed and why;
- implementation scope;
- visual parity notes for UI changes;
- validation performed;
- known limitations or deferred work.

For visual work, include screenshots when available and explicitly note any intentional deviation from `origina-next`.

Do not merge automatically unless the owner explicitly requests it.

## Merge policy

Prefer squash merge for focused PRs. Preserve individual commits when their sequence materially helps review or migration history. Never rewrite shared `main` history.
