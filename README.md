# Tasks for Today — Laravel TSA2 Rebuild

This project rebuilds the supplied CodeIgniter Tasks for Today system in Laravel 11. It includes full task CRUD, validation, Breeze authentication support, public pages, authentication-protected management actions, `is_archived` soft deletion, and a completion email that uses Laravel's `log` mail driver by default. Laravel 11 is used because it supports PHP 8.2, which is included with the current XAMPP setup.

## Local setup

```bash
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

The Composer audit setting is disabled for dependency installation because this classroom project targets Laravel 11 on PHP 8.2. For a production deployment, use the latest supported Laravel/PHP combination instead.

Open `http://localhost:8000`. The seeded account is `ferrence.alagad@example.com` with password `TaskToday123!`. Change this password before deployment.

The project declares `laravel/breeze` as a development dependency. To regenerate the standard Breeze Blade scaffolding in a fresh Laravel install, run `php artisan breeze:install blade`, then `npm install && npm run build`. The submitted routes keep the same Breeze-compatible session authentication behavior while keeping this lab's pages small and easy to inspect.

## Email verification

The default `.env.example` uses `MAIL_MAILER=log`, so no real email is sent. After changing a pending or `in progress` task to `done`, inspect `storage/logs/laravel.log` for the generated message. Editing an already-done task does not send another message because the controller checks the previous status before updating.

## Required flow to demonstrate

1. Visit `/tasks` while logged out: the list is public, but management controls are unavailable.
2. Log in, create a task, edit it, and archive it. Archiving sets `is_archived=1` instead of deleting the row.
3. Edit a pending task and choose `done`; confirm one `Task completed` message in the log.
4. Edit that already-done task again; confirm no second completion message is added.

For deployment, set the host's document root to `public/`, configure a persistent database, run migrations/seeding, and set `APP_ENV=production` and `APP_DEBUG=false`.
