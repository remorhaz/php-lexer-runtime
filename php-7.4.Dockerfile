FROM php:7.4-cli

RUN apt-get update &&  apt-get install -y \
    zip \
    git \
    libicu-dev && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-configure intl --enable-intl && \
    docker-php-ext-install intl pcntl

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_PROCESS_TIMEOUT=1200

RUN curl --silent --show-error https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer
