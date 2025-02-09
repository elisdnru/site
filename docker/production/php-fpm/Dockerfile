FROM node:22-alpine3.20 as builder

WORKDIR /app

COPY ./package.json ./yarn.lock ./
RUN yarn install && yarn cache clean

COPY ./ ./
RUN yarn build

FROM php:8.4-fpm-alpine3.21

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev icu-dev git \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd intl opcache \
    && apk del git

RUN apk add --no-cache fcgi

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --version=2.8.5 --quiet

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --optimize-autoloader \
    && rm -rf /root/.composer/cache

COPY --from=builder /app/public/build ./public/build
COPY ./ ./

RUN chown www-data:www-data ./var -R

HEALTHCHECK --interval=10s --timeout=3s --start-period=10s \
    CMD REDIRECT_STATUS=true SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1
