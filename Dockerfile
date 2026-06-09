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

# Added --ignore-platform-reqs to bypass extension checks in this isolated stage
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --ignore-platform-reqs

# ============================================================
# Stage 3 - Runtime
# ============================================================
# ============================================================
# Stage 3 - Runtime
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

# 1. Copy your project files
COPY . .

# 2. Copy the vendors we downloaded in Stage 2
COPY --from=vendor /app/vendor ./vendor

# 3. Copy frontend assets
COPY --from=frontend /app/public/build ./public/build

# 4. Create your storage directories FIRST so Laravel has its cache paths
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN touch career-portfolio
RUN chmod -R 777 storage bootstrap/cache database

# === THE FIX: Copy the Composer binary from the vendor stage ===
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# 5. NOW optimize the autoloader safely
RUN composer dump-autoload --optimize

# Cache clear so build doesn't fail
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

EXPOSE 10000

CMD sh -c "\
php artisan migrate --force && \
php artisan db:seed --force && \
php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"