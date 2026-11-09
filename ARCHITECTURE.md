# Architecture — Sync Ops Console

Full-stack senior demo: **Laravel API + React UI** for observing async sync jobs.

## Intent

Hiring managers for full-stack / platform roles want proof you can:

1. Expose a clean JSON API for operational data
2. Build an internal UI that operators can actually use
3. Model job lifecycle (`queued → running → succeeded|failed`)

## Components

```
React (Vite) ──HTTP──► Laravel /api/jobs
                         │
                         ▼
                      sync_jobs table
```

CORS enabled for local Vite. In production, serve UI from same origin or API gateway.

## Senior notes

- API is the contract; UI is a client
- Failed jobs expose `last_error` for triage
- Requeue endpoint resets status without deleting history (append attempt count)
