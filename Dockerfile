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
    git \
    unzip \
    zip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    intl

WORKDIR /var/www/html

# Copy Application
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

# Storage
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views


RUN chmod -R 775 storage bootstrap/cache

# Laravel cache files
# RUN php artisan package:discover --ansi || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}