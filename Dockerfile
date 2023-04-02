FROM composer:2 AS composer
FROM php:8.1.11-alpine AS base

ENV \
    COMPOSER_ALLOW_SUPERUSER="1" \
    COMPOSER_HOME="/tmp/composer" \
    OWN_SSL_CERT_DIR="/ssl-cert" \
    OWN_SSL_CERT_LIFETIME=1095

# persistent / runtime deps
ENV PHPIZE_DEPS \
    librdkafka-dev \
    rabbitmq-c-dev \
    build-base \
    autoconf \
    libc-dev \
    pcre-dev \
    openssl \
    pkgconf \
    cmake \
    make \
    file \
    re2c \
    g++ \
    gcc

# repmanent deps
ENV PERMANENT_DEPS \
    postgresql-dev \
    git \
    openssh

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN set -xe \
    && apk add --no-cache ${PERMANENT_DEPS} \
    && apk add --no-cache --virtual .build-deps ${PHPIZE_DEPS} \
    # https://github.com/docker-library/php/issues/240
    && apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/community gnu-libiconv \
    && pecl install rdkafka-5.0.2 \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-enable rdkafka \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-source extract \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-install -j$(nproc) \
        sockets \
        pdo_pgsql \
        opcache \
        bcmath \
        pcntl \
        exif \
    && docker-php-ext-configure exif --enable-exif \
    && apk del .build-deps \
    && rm -rf /app /home/user ${COMPOSER_HOME} /var/cache/apk/* \
    && mkdir /app /home/user

COPY ./docker/php.ini /usr/local/etc/php/php.ini-production
COPY ./docker/php-development.ini /usr/local/etc/php/php.ini-development
COPY ./docker/php.ini /usr/local/etc/php/php.ini
COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN mkdir -p ${OWN_SSL_CERT_DIR} \
    && cd ${OWN_SSL_CERT_DIR} \
    && openssl genrsa -passout pass:x -out self-signed.key 2048 \
    && cp self-signed.key self-signed.key.orig \
    && openssl rsa -passin pass:x -in self-signed.key.orig -out self-signed.key \
    && openssl req -new -key self-signed.key -out cert.csr \
        -subj "/C=RU/ST=RU/L=Somewhere/O=SomeOrg/OU=IT Department/CN=example.com" \
    && openssl x509 -req -days ${OWN_SSL_CERT_LIFETIME} -in cert.csr -signkey self-signed.key -out self-signed.crt

WORKDIR /app

COPY . /app
