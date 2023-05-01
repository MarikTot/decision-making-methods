FROM php:8-alpine

WORKDIR /app

RUN set -ex && apk --no-cache add postgresql-dev libsodium-dev librdkafka-dev git autoconf gcc g++ make bash curl-dev libtool nodejs npm \
    && pecl install rdkafka-5.0.2 \
    && docker-php-ext-enable rdkafka \
    && docker-php-ext-install pdo pdo_pgsql

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

CMD tail -f /dev/null
