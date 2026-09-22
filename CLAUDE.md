# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Laravel 10 admin panel ("MonkLife") built on **Filament 3** (admin UI) + **Jetstream/Fortify + Livewire 3** (member-facing pages) + **Spatie Permission** (roles/permissions). Domain: vehicle booking (CRS) and broadcast notifications (NTFY) for a monastic/organization membership, with Thai-language UI strings and LINE Notify integration.

## Environment

- Herd's linked PHP for this site resolves to 8.2 (`herd which-php`), but the plain `php`/`composer` on `$PATH` may resolve to a newer Homebrew PHP (e.g. 8.4) that's too new for the locked Composer packages (`nette/schema`, `nette/utils` require PHP <= 8.3). Run Composer with the Herd PHP 8.2 binary explicitly to avoid ambiguity:
  `"/Users/bunchapomsuwun/Library/Application Support/Herd/bin/php82" "/Users/bunchapomsuwun/Library/Application Support/Herd/bin/composer" install`
- Served via Laravel Herd at `http://monklife-admin.test` (parked directory). Local MySQL (Homebrew) database: `monklife_admin`, user `root`, no password.
- Filament admin panel lives at `/admin`; access is gated by `User::canAccessPanel()` which requires the `Admin` Spatie role (`app/Models/User.php`).

## Commands

```bash
# Composer (must use php82, see above)
"/Users/bunchapomsuwun/Library/Application Support/Herd/bin/php82" "/Users/bunchapomsuwun/Library/Application Support/Herd/bin/composer" install

# Artisan / tests (php82 or Herd's default php both work at runtime)
php artisan migrate
php artisan test                        # full suite
php artisan test --filter=TestName      # single test
vendor/bin/phpunit tests/Feature/AuthenticationTest.php

# Frontend
npm install
npm run dev      # vite dev server
npm run build     # production assets (Tailwind + Alpine + Filament)

# Filament
php artisan make:filament-resource ModelName
php artisan make:filament-user
```

Tests use `phpunit.xml`'s configured `APP_ENV=testing` but do **not** switch to sqlite (the sqlite env lines are commented out), so `php artisan test` runs against the real `DB_CONNECTION` in `.env` — be mindful of that when writing/running Feature tests that touch the database. The existing suite (`tests/Feature/**`) only covers Jetstream/Fortify auth scaffolding (login, registration, 2FA, API tokens, etc.) — there is no Feature test coverage for the CRS or NTFY domain modules.

## Architecture

**Two parallel UIs on the same models:**
- **Filament resources** (`app/Filament/Resources/**`) — the `/admin` panel for `Admin`-role users. Resources exist for `CRS\Car`, `CRS\Driver`, `CRS\Lists`, `NTFY\Ntfy`, plus Spatie `Role`/`Permission` and `User`.
- **Livewire full-page components** (`app/Livewire/**`) — member-facing pages wired directly into `routes/web.php` (e.g. `Crs\CrsLists`, `Crs\CrsCreate`/`CrsEdit`, `Ntfy\NtfyLists`, `User\UserEdit`). These are gated per-route by Spatie `role:`/`permission:` middleware using **Thai permission names** (`permission:สมาชิก`, `permission:จองรถ`, `permission:แจ้งเตือน`), not English — check `routes/web.php` before adding new gated routes.

**Domain modules:**
- `App\Models\CRS\*` (Car, Driver, Lists) — vehicle booking. `Lists` is the booking record, belongs to `Car`, `Driver` (via `driver_id`), and `User` (the requester). `Driver` belongs to `User` (a driver is a User with a driver record).
- `App\Models\NTFY\Ntfy` — scheduled broadcast notices with an image, Thai body text, and `passenger` (array cast) recipients; `scopeActived`/`scopePublished` control visibility.
- `Ntfy` cleans up its stored `image` file via model `boot()` `updating`/`deleting` hooks (`app/Models/NTFY/Ntfy.php`) — follow this pattern for any new file-attached model rather than leaving orphaned files in `storage/app/public`. `Lists` has no file field, so no equivalent cleanup is needed there.
- `ListObserver` (`app/Observers/ListObserver.php`, registered in `EventServiceProvider`) is wired to the `Lists` model's `created`/`restored`/`forceDeleted` events but every method is currently an empty stub — don't assume booking creation triggers a LINE notification or other side effect through it; that logic lives only in the scheduled `app:crs-daily` command below.

**Scheduled jobs** (`app/Console/Kernel.php`) push to LINE Notify via `phattarachai/line-notify`:
- `app:ntfy-send` (every minute) — sends any `Ntfy` whose `published_at` matches the current date/time.
- `app:crs-daily` (daily at 06:00) — sends the day's `Lists` (car bookings) summary, formatted with `phattarachai/thaidate` for Thai calendar dates.
- LINE Notify tokens are currently hardcoded in `CrsDaily`/`NtfySend` — if refactoring, move them to config/`.env` rather than leaving new hardcoded tokens.

**Known typo trap:** a historical migration (`database/migrations/2023_10_19_103932_create_lists_table.php`) originally imported a non-existent `App\Models\CRS\Diver` class instead of `Driver` — already fixed locally, but be aware similar naming inconsistencies (`Diver`/`Ntfy`/`NTFY` vs `Ntfy`) exist across the codebase and are intentional class names, not typos to "fix" blindly.

`config/app.php` sets `timezone => Asia/Bangkok` but `locale => en` (not `th`) — Thai text in this app is hardcoded into strings/views rather than routed through Laravel's localization files.

## MCP servers

- **laravel-boost** (`.mcp.json`, project-scoped) — Laravel's official MCP server (`laravel/boost`, dev dependency), exposing Artisan/Eloquent/route/log introspection tools. Pinned to the Herd PHP 8.2 binary rather than plain `php` because PHP 8.4 (Herd's default `php` shim) emits `Deprecated:` notices from old vendor code (Termwind, PsySH, thecodingmachine/safe) straight to **stdout**, which corrupts the MCP JSON-RPC stream. If PHP 8.4's deprecation noise is ever silenced upstream, `command` can be simplified back to plain `php`.
- **context7** (`.mcp.json`, project-scoped) — up-to-date library/framework docs lookup, added via HTTP transport (`https://mcp.context7.com/mcp`). No API key configured; works against context7's public rate limits, add one via the `CONTEXT7_API_KEY` env var in the server config if rate limiting becomes an issue.
