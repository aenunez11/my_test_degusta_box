FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

RUN a2enmod rewrite


ENV APACHE_DOCUMENT_ROOT /var/www/html/public


COPY . /var/www/html


RUN chown -R www-data:www-data /var/www/html


WORKDIR /var/www/html


EXPOSE 80
