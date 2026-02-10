# Use official PHP 8.4 FPM on Alpine - small and secure
FROM php:8.4-fpm-alpine

# Install system dependencies (dev libs for extensions + runtime tools)
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy your Laravel code (from build context = ./backend)
COPY . .

# Install Composer dependencies (production-optimized)
RUN composer install --optimize-autoloader --no-dev --prefer-dist

# Set permissions for Laravel storage/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose FPM port
EXPOSE 9000

CMD ["php-fpm"]