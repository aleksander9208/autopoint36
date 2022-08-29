FROM php:7.1-fpm

WORKDIR /application

RUN apt-get update \
    && apt-get install -y \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxpm-dev \
        libzip-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        cron \
        libxml2-dev \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype-dir --with-jpeg-dir \
    && docker-php-ext-install \
        mysqli \
        gd \
        soap \
    && pecl install xdebug-2.5.0 \
    && curl -sS https://getcomposer.org/installer | php -- --version=1.9.3 --install-dir=/usr/local/bin/ --filename=composer \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#        memcache \
#        memcached \
#        intl \
#        pdo_mysql \
#        mcrypt \
#        opcache \
#        interbase \

COPY ./php-ini-overrides.ini /usr/local/etc/php/conf.d/php-ini-overrides.ini

RUN usermod -u 1000 www-data