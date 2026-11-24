FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --chown=www-data:www-data . /var/www/html/

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

EXPOSE 80