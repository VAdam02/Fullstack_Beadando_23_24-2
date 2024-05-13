# Use the official PHP image as a base
FROM php:8.1-fqm

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

RUN apt-get install -y nodejs npm

# Copy composer.lock and composer.json
COPY composer.lock composer.json ./

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-autoloader --no-scripts

# Copy existing application directory contents
COPY . .

RUN composer update
RUN composer install
RUN npm install
RUN php artisan key:generate

RUN npm run build

# Expose port 8000 and start php-fpm server
EXPOSE 8000
CMD ["php artisan serve"]
