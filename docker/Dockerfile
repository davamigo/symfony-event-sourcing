# See https://hub.docker.com/_/php/
FROM php:7.1-apache

# Install O.S extensions
RUN apt-get update \
 && apt-get -y install \
        zip \
        unzip \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev

# Prepare environment
RUN docker-php-ext-install \
        pdo_mysql \
        bcmath

RUN pecl install mongodb

RUN docker-php-ext-enable \
        pdo_mysql \
        bcmath \
        mongodb

RUN useradd -m -u 1000 -U david

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && php -r "unlink('composer-setup.php');"

# Set the working directory
WORKDIR /var/www/html
