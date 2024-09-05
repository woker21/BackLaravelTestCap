# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala las dependencias del sistema y extensiones de PHP
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

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Configurar Apache para que use "public" como directorio raíz
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto en el contenedor
COPY . /var/www/html

# Instala las dependencias de Composer
RUN composer install --no-interaction --no-plugins --no-scripts

# Genera la clave de la aplicación
RUN php artisan key:generate

# Asigna permisos a las carpetas de Laravel necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Optimiza la configuración para producción
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expone el puerto 80 para acceder a la aplicación
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]