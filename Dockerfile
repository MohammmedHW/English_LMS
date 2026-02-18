# Stage 1: build PHP + Node assets
FROM php:8.4-cli AS builder

WORKDIR /var/www

# Install dependencies + Node
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl nodejs npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build Vite assets
RUN npm install
RUN npm run build

# Clear caches
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear

# Stage 2: Production image with PHP-FPM only
FROM php:8.4-fpm

WORKDIR /var/www

# Copy built app from builder
COPY --from=builder /var/www /var/www

# Expose port 8080
EXPOSE 8080

# Start PHP-FPM only
CMD ["php-fpm", "-F"]
