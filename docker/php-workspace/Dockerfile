ARG DOCKER_PHP_VERSION

FROM php:${DOCKER_PHP_VERSION}-fpm

ARG TZ='UTC'

USER root

RUN rm /etc/apt/preferences.d/no-debian-php

RUN apt-get update && apt-get install -y \
        supervisor \
        imagemagick \
        libxslt-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6  \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        patch \
        bash \
        htop \
        curl \
        vim \
        openssh-client \
        python3 \
        python3-pip \
        mariadb-client \
        npm

RUN apt-get install -y \
            wget \
            gzip \
            tar

#  Install php extensions
RUN php -m && \
    docker-php-ext-configure bcmath --enable-bcmath && \
    docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      --with-jpeg=/usr/include/ && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-configure soap && \
    docker-php-ext-install exif \
        mysqli \
        ftp \
        opcache \
        xsl \
        bcmath \
        gd \
        gettext \
        intl \
        pcntl \
        soap \
        sysvsem \
        zip \
        pdo_mysql && \
    docker-php-ext-install zip

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

USER root

RUN python3 -m pip install --upgrade supervisor --break-system-packages
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /var/www/

USER www-data:www-data
