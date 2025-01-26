FROM php:8.3-apache

# Instalar las extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Copiar el archivo de configuración de Apache
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Asegúrate de que la carpeta de trabajo esté configurada correctamente
WORKDIR /var/www/html
