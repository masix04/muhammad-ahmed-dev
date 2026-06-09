# ============================================================
# Stage 1 - Build Frontend Assets
# ============================================================
FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build


# ============================================================
# Stage 2 - Install PHP Dependencies
# ============================================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize


# ============================================================
# Stage 3 - Production Runtime
# ============================================================
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    zip \
    curl \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    intl

WORKDIR /var/www/html

COPY . .

COPY --from=vendor /app/vendor ./vendor

COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

RUN touch database/database.sqlite

EXPOSE 10000

CMD php artisan serve \ --host=0.0.0.0 \ --port=${PORT:-10000}