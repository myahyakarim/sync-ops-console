# Architecture — Sync Ops Console

Laravel API + React UI for observing async sync jobs.

## Goals

1. Clear JSON API for operational job data
2. Operator UI for triage without SSH
3. Explicit job lifecycle: `queued → running → succeeded|failed`

## Components

```
React (Vite) ──HTTP──► Laravel /api/jobs
                         │
                         ▼
                      sync_jobs table
```

CORS is enabled for local Vite. In production, serve the UI from the same origin or an API gateway.

## Notes

- API is the contract; UI is a client
- Failed jobs expose `last_error` for triage
- Requeue resets status and increments attempts without deleting history
