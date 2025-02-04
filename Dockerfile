FROM php:8.0.30-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar paquete de desarrollo de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html
RUN sudo chown -R /var/www/html/app/db/*
RUN sudo chmod 7777 /var/www/html/app/db/*

WORKDIR /var/www/html
WORKDIR /var/www/html/app/db

CMD ["apache2-foreground"]
