FROM php:8.5-fpm-alpine3.23

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev icu-dev git linux-headers \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd intl \
    && apk del git linux-headers

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d

RUN apk add --no-cache shadow

ARG UID=1000
ARG GID=1000

RUN groupmod -g "${GID}" www-data && usermod -u "${UID}" www-data

WORKDIR /app
