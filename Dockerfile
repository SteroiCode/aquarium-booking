FROM php:8.2-apache

# Install PHP extensions + OPcache
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure OPcache for performance
RUN echo "opcache.enable=1\n\
opcache.memory_consumption=128\n\
opcache.interned_strings_buffer=8\n\
opcache.max_accelerated_files=10000\n\
opcache.revalidate_freq=0\n\
opcache.validate_timestamps=0\n\
opcache.fast_shutdown=1" > /usr/local/etc/php/conf.d/opcache.ini

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set Apache document root to Laravel public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Allow .htaccess overrides
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Storage permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create startup script
RUN echo '#!/bin/bash\n\
set -e\n\
echo "==> Clearing caches..."\n\
php artisan config:clear\n\
php artisan cache:clear\n\
echo "==> Running migrations..."\n\
php artisan migrate --force\n\
echo "==> Seeding admin user..."\n\
php artisan db:seed --class=AdminUserSeeder --force 2>/dev/null || true\n\
echo "==> Storage link..."\n\
php artisan storage:link 2>/dev/null || true\n\
echo "==> Fix storage permissions..."\n\
chmod -R 777 /var/www/html/storage\n\
chmod -R 777 /var/www/html/bootstrap/cache\n\
echo "==> Caching config/routes/views..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
php artisan event:cache\n\
echo "==> Starting Apache..."\n\
apache2-foreground' > /start.sh && chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
