FROM php:8.5-fpm

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} laravel \
    && useradd -u ${UID} -g laravel -m laravel

RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
USER laravel
