# syntax=docker/dockerfile:1

ARG PHP_VARIANT=cli

FROM php:8.4-${PHP_VARIANT}-alpine AS base

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache \
        bash \
        git \
        vim \
        curl \
        unzip \
        zip \
        mysql-client \
        linux-headers \
        $PHPIZE_DEPS \
    && docker-php-ext-install pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN addgroup -g ${GID} app \
    && adduser -D -u ${UID} -G app -s /bin/bash app

WORKDIR /app

ENV COMPOSER_HOME=/home/app/.config/composer
ENV PATH="${COMPOSER_HOME}/vendor/bin:${PATH}"

#
# php-build
#
FROM base AS php-build

RUN apk add --no-cache nodejs npm

USER app

RUN composer global require laravel/installer

CMD ["bash"]

#
# php-cli
#
FROM base AS php-cli

USER root

RUN docker-php-ext-install pcntl

USER app

CMD ["bash"]

#
# php-fpm
#
FROM php:8.4-fpm-alpine AS php-fpm

ARG UID=1000
ARG GID=1000

RUN apk add --no-cache \
        bash \
        mysql-client \
    && docker-php-ext-install pdo_mysql

RUN addgroup -g ${GID} app \
    && adduser -D -u ${UID} -G app -s /bin/bash app

WORKDIR /app

USER app

CMD ["php-fpm"]