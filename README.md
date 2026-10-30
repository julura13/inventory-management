# Inventory Manager

A Laravel app for searching, adding, editing and deleting products through an external inventory API.

## Requirements

- PHP 8.2+ and Composer
- Node.js and npm
- Network access to the inventory API (`http://10.0.0.122:55500/Inventory`, set in `app/Http/Controllers/ApiController.php`)

## Setup

```sh
composer setup
```

This installs dependencies, creates `.env` from `.env.example`, generates the app key, runs the migrations and builds the frontend.

The app uses SQLite (`database/database.sqlite`) for sessions and users. If the file doesn't exist, create it first:

```sh
touch database/database.sqlite
```

## Run

```sh
composer dev
```

Then open http://localhost:8000.

## Tests

```sh
php artisan test
```
