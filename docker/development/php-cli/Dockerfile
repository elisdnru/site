FROM php:8.5-cli-alpine3.23

ENV XDEBUG_VERSION=3.5.0

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev icu-dev git linux-headers \
    && git clone -b $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd intl xdebug \
    && apk del git linux-headers

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php-cli/conf.d /usr/local/etc/php/conf.d

RUN apk add --no-cache bash coreutils

COPY ./common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --version=2.9.2 --quiet

ARG UID=1000
ARG GID=1000

RUN addgroup -g "${GID}" app && adduser -u "${UID}" -G app -s /bin/sh -D app

WORKDIR /app

USER app
