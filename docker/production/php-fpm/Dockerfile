FROM node:17-alpine as builder

WORKDIR /app

COPY ./package.json ./yarn.lock ./
RUN yarn install && yarn cache clean

COPY ./ ./
RUN yarn build

FROM php:8.1-fpm-alpine

RUN apk add --no-cache mariadb-client libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev libmcrypt-dev icu-dev git \
    && git clone --depth 1 https://github.com/php/pecl-encryption-mcrypt.git /usr/src/php/ext/mcrypt \
    && docker-php-ext-configure mcrypt \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd mcrypt intl opcache

RUN apk add --no-cache fcgi unzip

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --optimize-autoloader \
    && rm -rf /root/.composer/cache

COPY --from=builder /app/public/build ./public/build
COPY ./ ./

RUN chown www-data:www-data ./var -R

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s \
    CMD REDIRECT_STATUS=true SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1
