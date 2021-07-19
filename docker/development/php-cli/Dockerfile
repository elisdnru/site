FROM php:8.0-cli-alpine

ENV XDEBUG_VERSION 3.0.3

RUN apk add --no-cache mariadb-client libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev libmcrypt-dev git \
    && git clone --depth 1 https://github.com/php/pecl-encryption-mcrypt.git /usr/src/php/ext/mcrypt \
    && docker-php-ext-configure mcrypt \
    && git clone --depth 1 https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
    && docker-php-ext-configure redis \
    && git clone -b $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd mcrypt xdebug redis

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d

RUN apk add --no-cache wget unzip bash coreutils

COPY ./common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
