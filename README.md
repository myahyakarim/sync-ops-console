# Sync Ops Console

> Full-stack senior demo: **React + Laravel** internal console for async sync jobs.

Clean-room portfolio. Fictional **LedgerBridge Ops** — no employer code or brands.

## What it demonstrates

- Laravel JSON API (`/api/jobs`, filter, requeue)
- React TypeScript UI for operators
- Job lifecycle modeling for senior backend / full-stack interviews
- Architecture notes aimed at architect-level discussion

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

Set `VITE_API_URL=http://127.0.0.1:8000/api` if needed (default in App).

## Architecture

See [ARCHITECTURE.md](./ARCHITECTURE.md).

## Stack

PHP / Laravel · React · Vite · TypeScript · SQLite
