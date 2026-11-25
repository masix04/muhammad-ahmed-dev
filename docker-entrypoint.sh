#!/bin/sh
# Container start-up: prepare the database, then serve the site.
set -e

# Where the SQLite file lives. Point DB_DATABASE at a mounted disk
# (e.g. /var/data/portfolio.sqlite) and your data survives redeploys.
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-database/database.sqlite}"

    mkdir -p "$(dirname "$DB_FILE")"
    [ -f "$DB_FILE" ] || touch "$DB_FILE"
fi

# Uploaded images (project thumbnails, blog covers) are served from public/storage.
php artisan storage:link --force

php artisan migrate --force

# Only fills in what is missing — see DatabaseSeeder. Safe to run on every start.
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
