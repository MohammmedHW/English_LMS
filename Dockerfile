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

# Install frontend dependencies & build assets
RUN npm install
# Ensure the vite binary is executable to prevent "Permission Denied"
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

# Copy everything from builder
COPY --from=builder /var/www /var/www

# --- CRITICAL: Fix Permissions for Railway ---
# This ensures the web server can read the CSS/JS in public/build
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public

# Expose Railway port
ENV PORT=8080
EXPOSE 8080

# Switch to non-root user for better security and file handling
USER www-data

# Start Laravel
# We use sh -c to ensure the $PORT variable is correctly injected by Railway
CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"