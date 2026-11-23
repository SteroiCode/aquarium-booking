#!/bin/bash

echo "==> Clearing ALL caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

echo "==> Running migrations..."
php artisan migrate --force || true

echo "==> Seeding data (only if empty)..."
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "==> Database empty, seeding..."
    php artisan db:seed --class=AdminUserSeeder --force || true
    php artisan db:seed --class=SampleDataSeeder --force || true
    php artisan db:seed --class=SystemSettingsSeeder --force || true
else
    echo "==> Data already exists, skipping seed."
fi

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Fix permissions..."
chmod -R 777 /var/www/html/storage || true
chmod -R 777 /var/www/html/bootstrap/cache || true

echo "==> Starting Apache..."
apache2-foreground
