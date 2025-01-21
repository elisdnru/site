FROM php:8.4-cli-alpine3.21

RUN apk add --no-cache libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev git \
    && docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install pdo_mysql gd opcache

RUN apk add --no-cache bash coreutils

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php/conf.d /usr/local/etc/php/conf.d

COPY ./docker/common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --prefer-dist --no-progress --optimize-autoloader \
    && rm -rf /root/.composer/cache

COPY ./ ./

RUN chown -R app:app ./var ./public/assets

USER app
