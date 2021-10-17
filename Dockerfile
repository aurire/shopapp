FROM php:7.4-apache AS base

RUN apt-get update -y &&\
  apt-get -y --no-install-recommends install \
  libbz2-dev libc-client-dev libicu-dev libkrb5-dev libmcrypt-dev libgmp3-dev libxml2-dev libxslt-dev libzip-dev supervisor zlib1g-dev &&\
  docker-php-ext-install bcmath bz2 calendar ctype exif gettext gmp intl mysqli opcache pcntl pdo_mysql shmop sockets xsl zip &&\
  pecl install igbinary mcrypt redis &&\
  docker-php-ext-enable igbinary mcrypt redis &&\
  a2enmod allowmethods rewrite &&\
  apt-get autoremove -y &&\
  apt-get clean &&\
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /app

# -----------------------------------------------

FROM composer:2.0 AS vendor

COPY composer.json /app/

RUN --mount=type=ssh --mount=type=cache,target=/tmp/cache \
  composer install \
  --ignore-platform-reqs \
  --no-ansi \
  --no-autoloader \
  --no-dev \
  --no-interaction \
  --no-scripts

COPY . /app

RUN --mount=type=ssh composer dump-autoload --optimize --classmap-authoritative --ignore-platform-reqs

# -----------------------------------------------

FROM base AS development

ENV APACHE_SERVER_NAME "shopapp"
ENV APACHE_DOCUMENT_ROOT "/app/public"

RUN pecl install xdebug &&\
  docker-php-ext-enable xdebug &&\
  apt-get update &&\
  apt-get -y --no-install-recommends install sudo &&\
  apt-get autoremove -y &&\
  apt-get clean &&\
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY docker/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY --from=vendor /usr/bin/composer /usr/bin/composer
