# Dockerfile untuk Surveyasia-Skripsi

# --- Base Stage ---
FROM php:8.2-fpm as base

# Konfigurasi umum
WORKDIR /var/www/html
ENV DEBIAN_FRONTEND=noninteractive

# Install dependensi sistem yang umum dibutuhkan
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    wkhtmltopdf \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip exif pcntl gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- Vendor Stage ---
FROM base as vendor

# Copy file composer dan install dependensi
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# --- Frontend Stage ---
FROM node:18 as frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Production Stage ---
FROM php:8.2-fpm-alpine as production

WORKDIR /var/www/html

# Install dependensi production
RUN apk --no-cache add \
    nginx \
    supervisor \
    libzip \
    libpng \
    libjpeg \
    freetype \
    libxml2

# Konfigurasi Ekstensi PHP
RUN docker-php-ext-install pdo_mysql zip exif pcntl gd

# Copy file aplikasi dari base stage
COPY --from=vendor /var/www/html/vendor/ ./vendor/
COPY --from=frontend /app/public/ ./public/
COPY . .

# Copy .env.example to .env
RUN cp .env.example .env

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Nginx
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Konfigurasi Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Expose port
EXPOSE 80

# Jalankan Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
