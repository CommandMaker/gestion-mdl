FROM php:8.3-fpm

RUN apt-get update && apt-get install \
        git \
        libmcrypt-dev \
        libmagickwand-dev \
        libfreetype6-dev \
        libpng-dev \
        libzip-dev \
        libjpeg-dev -y

RUN pecl install apcu opcache imagick gd \
    &&  docker-php-ext-configure gd --with-freetype=/usr/include/freetype2 --with-jpeg=/usr/include \
    && docker-php-ext-install pdo gd \
    && docker-php-ext-enable apcu opcache imagick gd

WORKDIR /usr
RUN curl "https://getcomposer.org/installer" -o /usr/composer-setup.phar \
    && php /usr/composer-setup.phar \
    && cp /usr/composer.phar /usr/bin/composer

WORKDIR /var/www/html
