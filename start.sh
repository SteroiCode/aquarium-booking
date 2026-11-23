#!/bin/bash

echo "==> Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Seeding admin user..."
php artisan db:seed --class=AdminUserSeeder --force || true

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Fix permissions..."
chmod -R 777 /var/www/html/storage || true
chmod -R 777 /var/www/html/bootstrap/cache || true

echo "==> Caching for performance..."
php artisan config:cache || true
php artisan route:cache || true
# Don't cache views — causes issues with dynamic content
# php artisan view:cache || true

echo "==> Starting Apache..."
apache2-foreground
