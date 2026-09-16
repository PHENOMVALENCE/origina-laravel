# Git Workflow

## Branches

- `main` — release branch; changes arrive through reviewed pull requests.
- `masterchanges` — current foundation branch only.
- future branches — `feature/<scope>`, `fix/<scope>`, `docs/<scope>`, `refactor/<scope>`, `chore/<scope>`.

Keep branches short-lived once the initial foundation work is merged.

## Commits

Use Conventional Commits. One logical concern per commit. Examples:

```text
docs: establish origina engineering standards
build: scaffold laravel frontend application
feat: implement institutional homepage shell
ci: add frontend and php quality gates
```

Do not append agent/AI co-author trailers.

## Pull requests

Every PR should contain:

- context / problem
- scope
- notable implementation decisions
- screenshots for visual changes
- accessibility notes for UI changes
- security notes where relevant
- test/validation results
- known limitations / deferred work

Do not merge the PR automatically. Merge is an explicit owner/reviewer action.

## Merge policy

Prefer squash merge for focused PRs unless preserving the internal commit sequence is valuable. Never rewrite shared `main` history.

## Release hygiene

Tagging/versioning will be introduced before the first production Laravel release. Until then, `main` represents the accepted baseline but is not itself a statement of production readiness.
