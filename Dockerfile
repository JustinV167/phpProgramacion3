FROM php:8.0.30-apache
VOLUME ["/var/www/html/db"]

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar paquete de desarrollo de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/db \
    && chmod -R 775 /var/www/html/db

WORKDIR /var/www/html
CMD ["apache2-foreground"]