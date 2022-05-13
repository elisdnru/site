FROM php:8.1-fpm-alpine

ENV XDEBUG_VERSION 3.1.1

RUN apk add --no-cache mariadb-client libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev libmcrypt-dev icu-dev git \
    && git clone --depth 1 https://github.com/php/pecl-encryption-mcrypt.git /usr/src/php/ext/mcrypt \
    && docker-php-ext-configure mcrypt \
    && git clone -b $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd mcrypt intl xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d

COPY ./development/php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /app
