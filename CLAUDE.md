# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
composer run dev      # Start all dev processes concurrently (server, queue, logs, Vite)
composer run lint     # Auto-fix code style with Pint
composer run test     # Lint check + full Pest test suite
composer setup        # First-time setup (install deps, .env, key, migrate, build)
```

Run a single test file:
```bash
php artisan test tests/Feature/SomeTest.php
```

Build frontend assets:
```bash
npm run build
```

## Architecture

**Sleepy** is a Laravel 12 sleep tracking app. Users log sleep entries with bedtime, wake time, temperature, and a 1–5 rating, annotate them with tags and key points (positive/negative factors), and view analytics on a dashboard.

**Tech stack:** PHP 8.2, Laravel 12, Livewire 4, Flux UI (Pro), Tailwind CSS 4, Vite, SQLite (default), Pest (tests), Pint (linting).

### Data model

- `users` — authenticated via Laravel Fortify (supports 2FA)
- `sleep_entries` — belongs to user; has `in_bed_by`, `awake_at`, `temperature`, `rating`, `notes`; soft-deleted
- `tags` — belongs to user; many-to-many with sleep entries; soft-deleted
- `key_points` — belongs to a sleep entry; `is_positive` flag + `text`

### Key patterns

- **Livewire pages** live in `resources/views/pages/` as `.blade.php` files alongside optional `.test.php` test files.
- **`SleepEntryForm`** (`app/Livewire/Forms/SleepEntryForm.php`) manages all sleep entry form state, validation, tag syncing, and key point management.
- **Dashboard** (`resources/views/pages/dashboard.blade.php`) computes analytics inline: 7-day/monthly averages, top/bottom tags, day-of-week breakdowns, and average sleep duration using a circular mean for times that wrap midnight.
- Authentication is handled entirely by Fortify (`app/Providers/FortifyServiceProvider.php`); routes are in `routes/settings.php` and `routes/web.php`.
- HTML in user-entered notes is sanitized before persistence.

### Testing

Pest is the test runner. Feature tests go in `tests/Feature/`, unit tests in `tests/Unit/`. The test environment uses an in-memory SQLite database (configured in `phpunit.xml`).
