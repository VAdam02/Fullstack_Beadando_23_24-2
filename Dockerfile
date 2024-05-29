# Use the official PHP image as a base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
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

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . .

COPY ./nginx/nginx.conf /etc/nginx/sites-available/default

COPY .env.example .env

RUN composer update
RUN composer install
RUN npm install
RUN npm run build

#Laravel
RUN php artisan key:generate

#Storage
RUN php artisan storage:link

#Database
RUN touch /var/www/html/database/database.sqlite
RUN chown root:root /var/www/html/database/database.sqlite
RUN php artisan migrate:fresh --seed

RUN chmod -R 777 /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

CMD service nginx start && php-fpm
