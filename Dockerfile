# -----------------------------
# Stage 1: Build Laravel + Vite
# -----------------------------
FROM php:8.4-cli AS builder

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl

# Install Node.js properly (NodeSource - IMPORTANT)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install frontend dependencies & build assets
RUN npm install
RUN npm run build

# Clear Laravel caches
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear

# --------------------------------
# Stage 2: Production Runtime
# --------------------------------
FROM php:8.4-cli

WORKDIR /var/www

# Install required PHP extensions again
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Copy built app from builder
COPY --from=builder /var/www /var/www

# Expose Railway port
EXPOSE 8080

# Start Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
