
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip exif pcntl bcmath gd

RUN a2enmod rewrite

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-interaction --no-plugins --no-scripts

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 80

CMD ["apache2-foreground"]
