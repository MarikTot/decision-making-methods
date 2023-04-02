FROM php:8-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y git autoconf gcc g++ make bash curl libtool \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    libpq-dev \
    librdkafka-dev \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && docker-php-ext-install pdo pgsql pdo_pgsql zip xsl gd intl opcache exif mbstring pcntl sockets \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
