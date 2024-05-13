# Use the official PHP image as a base
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy composer.lock and composer.json
COPY composer.lock composer.json ./

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-autoloader --no-scripts

# Copy existing application directory contents
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

RUN npm run production

# Expose port 9000 and start php-fpm server
EXPOSE 8000
CMD ["php artisan serve"]
