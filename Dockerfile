FROM php:8.1-fpm

# Install dependency Laravel + GD
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libxml2-dev zip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip exif pcntl gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Install Node.js 16 (stabil untuk Laravel Mix)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

COPY . .

# Install dependency PHP
RUN composer install --no-dev --optimize-autoloader

# Install dependency JS + build dengan Laravel Mix
RUN npm install && npm run prod

# Jalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-3000}
