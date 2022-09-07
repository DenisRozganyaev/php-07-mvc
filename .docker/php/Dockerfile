FROM php:8.1-apache

RUN docker-php-ext-install -j$(nproc) pdo_mysql

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN /usr/sbin/a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN chmod -R 765 /var/www/html
