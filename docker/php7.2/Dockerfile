FROM php:7.2-fpm

RUN apt-get update \
    && apt-get -y install libssl-dev libc-client2007e-dev libkrb5-dev curl git \
    && curl -L -C - --progress-bar -o /usr/local/bin/composer https://getcomposer.org/composer.phar \
    && chmod 755 /usr/local/bin/composer \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql