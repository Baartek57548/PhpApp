FROM php:8.4-fpm
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        acl \
        cron \
        curl \
        git \
        gnupg \
        nano \
        unzip \
        vim \
        zip \
        g++ \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libxml2-dev \
        libpng-dev \
        libsodium-dev \
        libzip-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" bcmath dom gd intl mbstring opcache pdo_mysql sodium xml zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y --no-install-recommends nodejs && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

ENV DEBIAN_FRONTEND=teletype
