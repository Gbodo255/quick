# ==========================================
# Stage 1: Build Frontend SPA (React + Vite)
# ==========================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY Front_app/package*.json ./
RUN npm ci
COPY Front_app/ ./
ENV VITE_API_URL=""
RUN npm run build

# ==========================================
# Stage 2: Build Backend Assets (Admin Vite)
# ==========================================
FROM node:20-alpine AS backend-assets-builder
WORKDIR /app
COPY Back_app/package*.json ./
RUN npm ci
COPY Back_app/ ./
RUN npm run build

# ==========================================
# Stage 3: Vendor Composer Dependencies
# ==========================================
FROM composer:2 AS vendor-builder
WORKDIR /app
COPY Back_app/composer*.json ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# ==========================================
# Stage 4: Production Image (PHP 8.3 + Nginx)
# ==========================================
FROM php:8.3-fpm-alpine

# Install system dependencies, Nginx, Supervisor, SQLite, and required PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    freetype \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        zip \
        gd \
        intl \
        opcache \
        bcmath \
    && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

# PHP production configurations
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && echo "upload_max_filesize = 30M" >> "$PHP_INI_DIR/conf.d/uploads.ini" \
    && echo "post_max_size = 35M" >> "$PHP_INI_DIR/conf.d/uploads.ini" \
    && echo "memory_limit = 256M" >> "$PHP_INI_DIR/conf.d/uploads.ini" \
    && echo "max_execution_time = 120" >> "$PHP_INI_DIR/conf.d/uploads.ini"

WORKDIR /var/www

# Copy Frontend build output
COPY --from=frontend-builder /app/dist /var/www/frontend

# Copy Backend application
COPY Back_app /var/www/backend
COPY --from=vendor-builder /app/vendor /var/www/backend/vendor
COPY --from=backend-assets-builder /app/public/build /var/www/backend/public/build

# Copy configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Setup storage, cache, and sqlite database directory permissions
RUN mkdir -p /var/www/backend/storage /var/www/backend/bootstrap/cache /var/www/backend/database \
    && touch /var/www/backend/database/database.sqlite \
    && chown -R www-data:www-data /var/www/backend \
    && chmod -R 775 /var/www/backend/storage /var/www/backend/bootstrap/cache /var/www/backend/database

# Default Environment Variables
ENV PORT=10000 \
    APP_ENV=production \
    APP_DEBUG=false \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/backend/database/database.sqlite \
    SESSION_DRIVER=database \
    CACHE_STORE=database \
    QUEUE_CONNECTION=sync

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

