# Base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    bash \
    zip \
    unzip \
    curl \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    autoconf \
    gcc \
    g++ \
    make \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip intl mbstring bcmath opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy the entire application code first
COPY . .
# Create necessary directories and set permissions
RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache
# Install dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Run laravel artisan command during build
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear
# Expose port 8000
EXPOSE 8000

# Start Laravel server
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT}"]

