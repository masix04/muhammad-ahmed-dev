FROM php:8.3-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install dependencies first (better cache)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

COPY package.json package-lock.json* ./
RUN npm install

# Copy application
COPY . .

# Build frontend
RUN npm run build

# Finish composer
RUN composer dump-autoload --optimize

# SQLite database
RUN mkdir -p database
RUN touch database/database.sqlite

# Laravel directories
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN mkdir -p storage/logs

# Permissions
RUN chmod -R 775 storage bootstrap/cache database

EXPOSE 10000

CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}