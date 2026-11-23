#!/bin/bash

echo "==> Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Running seeders..."
php artisan db:seed --class=AdminUserSeeder --force || true
php artisan db:seed --class=SampleDataSeeder --force || true
php artisan db:seed --class=SystemSettingsSeeder --force || true

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Fix permissions..."
chmod -R 777 /var/www/html/storage || true
chmod -R 777 /var/www/html/bootstrap/cache || true

echo "==> Starting Apache..."
apache2-foreground
