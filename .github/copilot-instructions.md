# Copilot Instructions

## Build, test, lint
- **Build assets**: `npm run build` (Vite)
- **Dev servers**: `composer run dev` (runs `php artisan serve`, queue listener, pail logs, and Vite)
- **Frontend dev**: `npm run dev`
- **Tests**: `composer run test` or `php artisan test`
- **Single test**: `php artisan test --filter=PromptTest` (or any test class/method name)
- **Lint (PHP)**: `vendor/bin/pint`

## Architecture (big picture)
- Laravel application. HTTP entry points are defined in `routes/web.php` plus auth routes in `routes/auth.php`.
- Controllers live in `app/Http/Controllers` and coordinate Eloquent models from `app/Models` with Blade views in `resources/views`.
- Frontend assets are bundled by Vite. Entry points are `resources/css/app.css` and `resources/js/app.js` (see `vite.config.js`).
- Feature-oriented Blade templates are grouped under `resources/views` (e.g., `prompts`, `favorites`, `collections`, `tags`, `trending`, `settings`).

## Key conventions
- Route model binding is the default for resource routes (e.g., `{prompt}`, `{collection}`, `{user}`); tags use slug binding via `{tag:slug}`. Keep controller signatures aligned.
- Most feature routes sit behind the `auth` middleware group in `routes/web.php`; public routes are limited to home/leaderboard/auth.
- JavaScript modules are wired through `resources/js/app.js` (currently `copyPrompt` and `toast`). Add new browser behavior by importing there.
- Vite asset inputs are declared via the Laravel Vite plugin in `vite.config.js`; add new entry points to the `input` array.
