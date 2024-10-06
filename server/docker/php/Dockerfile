FROM php:8.2-fpm

RUN apt-get update && apt-get install \
        git \
        libzip-dev \
        libmagickwand-dev \
        libpng-dev \
        wget \
        libfreetype6-dev \
        libmcrypt-dev \
        libjpeg-dev \
        libpng-dev -y

RUN pecl install xdebug apcu opcache imagick gd \
    &&  docker-php-ext-configure gd --with-freetype=/usr/include/freetype2 --with-jpeg=/usr/include \
    && docker-php-ext-install mysqli pdo pdo_mysql zip gd \
    && docker-php-ext-enable xdebug apcu opcache zip imagick gd

WORKDIR /usr
RUN curl "https://getcomposer.org/installer" -o /usr/composer-setup.phar \
    && php /usr/composer-setup.phar \
    && cp /usr/composer.phar /usr/bin/composer

WORKDIR /var/www/html
