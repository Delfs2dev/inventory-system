# Base PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PostgreSQL driver
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache rewrite module for Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Composer binary from official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies (optimize for production)
RUN composer install --no-dev --optimize-autoloader

# Cache Laravel config & routes
RUN php artisan config:cache \
    && php artisan route:cache

# Run database migrations automatically (safe for production)
RUN php artisan migrate --force || true

# Expose port 8000 (Render expects apps to bind here)
EXPOSE 8000

# Start Apache server
CMD ["apache2-foreground"]
