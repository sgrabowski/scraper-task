# Use an official PHP image as the base image
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
  git \
  unzip

COPY ../../ /app/

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

