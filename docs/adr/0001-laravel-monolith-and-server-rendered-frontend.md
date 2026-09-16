# ADR 0001: Laravel monolith with server-rendered Blade frontend

- Status: Accepted for foundation phase
- Date: 2026-09-16

## Context

ORIGINA is being re-platformed from an existing Next.js implementation. The owner is highly familiar with PHP/Laravel and wants a production-quality application capable of growing from institutional presentation into secure commerce and administration.

The first approved implementation scope is frontend-only.

## Decision

Use Laravel 12 as a modular monolith, Blade for server-rendered public views, Vite for assets, project CSS for the design system and minimal vanilla JavaScript for progressive enhancement.

Do not introduce a SPA framework in the foundation phase.

## Consequences

Positive:
- one primary application runtime
- strong Laravel security conventions
- excellent server-rendered SEO baseline
- low JavaScript cost on institutional pages
- straightforward future integration with Laravel policies, queues, notifications and commerce services

Trade-offs:
- highly interactive future interfaces may eventually justify Livewire, Alpine or a dedicated client application
- careful domain discipline is required so the monolith does not become tightly coupled

Any later adoption of a frontend framework requires a new ADR with a concrete product need.
