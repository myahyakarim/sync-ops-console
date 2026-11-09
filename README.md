# Sync Ops Console

React + Laravel console for monitoring async sync jobs: filter by status, inspect failures, and requeue safely.

## Problem

Async sync work fails in production. Operators need a simple UI over a clear job API — not SSH and log grepping.

## Approach

- Laravel JSON API: list / create / requeue jobs
- React TypeScript UI for triage
- Job lifecycle: `queued → running → succeeded|failed`

Details: [ARCHITECTURE.md](./ARCHITECTURE.md)

## Run

```bash
# API
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve

# UI
cd web
npm install
npm run dev
```

API default: `http://127.0.0.1:8000/api` (`VITE_API_URL` overrides).

## Stack

PHP / Laravel · React · Vite · TypeScript · SQLite
