# -----------------------------
# Stage 1: Build Laravel + Vite
# -----------------------------
FROM php:8.4-cli AS builder

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libxml2-dev libonig-dev

# Install Node 20 properly
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

# --- FIX: Fix permissions before building ---
RUN npm install
# Ensure the vite binary is executable
RUN chmod +x node_modules/.bin/vite
RUN npm run build

# --------------------------------
# Stage 2: Production Runtime
# --------------------------------
FROM php:8.4-cli

WORKDIR /var/www

# Install runtime dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev libonig-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Copy ONLY the necessary files from builder to keep image slim
COPY --from=builder /var/www /var/www

# Expose Railway port
ENV PORT=8080
EXPOSE 8080

# Start Laravel
# Using "sh -c" helps ensure environment variables like $PORT are parsed correctly
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT