FROM php:8.1-cli-alpine

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

RUN apk add --no-cache wget unzip bash coreutils

COPY ./common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

WORKDIR /app

USER app
