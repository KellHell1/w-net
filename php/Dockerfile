FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www
COPY composer.json /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sSL https://github.com/symfony/cli/releases/download/v6.4.0/symfony_linux_amd64 -o /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony