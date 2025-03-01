FROM php:8.4.4-fpm-alpine

ARG USER_NAME
ARG UID
ARG GID

RUN apk add --no-cache --virtual .build-deps icu-dev libzip-dev zip autoconf g++ make linux-headers \
    && apk add --no-cache icu-libs libzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql zip \
    && pecl install xdebug-3.4.1 \
    && docker-php-ext-enable opcache xdebug \
    && apk del .build-deps

COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/php.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN addgroup -g $GID $USER_NAME \
    && adduser -u $UID -G $USER_NAME -h /home/$USER_NAME -s /bin/sh -D $USER_NAME \
    && chown -R $USER_NAME:$USER_NAME /var/www/html

USER $USER_NAME