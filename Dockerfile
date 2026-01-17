# =============================================================================
# Base Stage - Common PHP setup
# =============================================================================
FROM php:8.4-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    icu-dev \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    intl

# Create system user for running Composer and Artisan Commands
RUN addgroup -g 1000 www && \
    adduser -u 1000 -G www -h /home/www -D www

# Set working directory
WORKDIR /var/www/html

# Create required directories
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    /var/www/html/database

# =============================================================================
# Development Stage
# =============================================================================
FROM base AS development

# Install Xdebug
RUN apk add --no-cache $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Configure Xdebug
RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN apk add --no-cache nodejs npm

# PHP development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Copy application files
COPY --chown=www:www . /var/www/html

# Set permissions
RUN chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache

USER www

EXPOSE 9000

CMD ["php-fpm"]

# =============================================================================
# Frontend Builder Stage
# =============================================================================
FROM node:20-alpine AS frontend-builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm ci

# Copy source files needed for build
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public

# Build assets
RUN npm run build

# =============================================================================
# Production Stage
# =============================================================================
FROM base AS production

# Install OPcache
RUN docker-php-ext-install opcache

# Configure OPcache for production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.revalidate_freq=0" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# PHP production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY --chown=www:www . /var/www/html

# Copy built frontend assets from builder stage
COPY --from=frontend-builder --chown=www:www /app/public/build /var/www/html/public/build

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache

# Create SQLite database if not exists
RUN touch /var/www/html/database/database.sqlite && \
    chown www:www /var/www/html/database/database.sqlite

USER www

EXPOSE 9000

CMD ["php-fpm"]
