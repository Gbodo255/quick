#!/bin/bash
set -e

# Dynamically set port if provided by host (e.g., Render sets $PORT)
if [ -n "$PORT" ]; then
    sed -i "s/listen 10000/listen $PORT/g" /etc/nginx/http.d/default.conf
fi

cd /var/www/backend

# Create .env from template if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Ensure APP_KEY exists
if [ -z "$APP_KEY" ]; then
    if ! grep -q "^APP_KEY=base64:" .env; then
        php artisan key:generate --force
    fi
fi

# SQLite initialization
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/backend/database/database.sqlite}"
    mkdir -p "$(dirname "$DB_FILE")"
    if [ ! -f "$DB_FILE" ]; then
        touch "$DB_FILE"
    fi
    chown -R www-data:www-data "$(dirname "$DB_FILE")"
    chmod 775 "$(dirname "$DB_FILE")"
    chmod 664 "$DB_FILE"
fi

# Ensure storage directories exist and have proper permissions
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Run migrations and storage link
php artisan storage:link --force || true
php artisan migrate --force

# Optimize Laravel for production
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "QuickCredit is ready! Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

