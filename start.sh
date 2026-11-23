#!/bin/bash

echo "==> Clearing ALL caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Seeding admin user..."
php artisan db:seed --class=AdminUserSeeder --force || true

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Fix permissions..."
chmod -R 777 /var/www/html/storage || true
chmod -R 777 /var/www/html/bootstrap/cache || true

echo "==> Starting Apache..."
apache2-foreground
