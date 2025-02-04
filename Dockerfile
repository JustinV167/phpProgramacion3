FROM php:8.0.30-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar paquete de desarrollo de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html/app/db/sqliteDB.sqlite
RUN chmod 777 /var/www/html/app/db/sqliteDB.sqlite

WORKDIR /var/www/html
CMD ["apache2-foreground"]
