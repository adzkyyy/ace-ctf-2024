# Node.js environment
FROM node:21-alpine as deps

ENV LANG="C.UTF-8" PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true

WORKDIR /home/bot

COPY ./bot/*.json .

RUN npm install

COPY ./bot/ .

USER node

# PHP environment
FROM php:8.1-apache

# Install necessary APK packages for PHP environment
RUN apt update -y && apt install -y unzip wget
RUN apt install -y --no-install-recommends nodejs
RUN apt install -y --no-install-recommends zlib1g-dev udev ca-certificates chromium
RUN apt install -y --no-install-recommends libzip-dev zip

WORKDIR /var/www/html

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

RUN chown www-data:www-data /var/www

USER www-data

RUN wp core download --path=/var/www/html/ --version=6.6.1

USER root

RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

RUN docker-php-ext-install zip \
    && docker-php-ext-enable zip

#install xdebug
# RUN pecl install xdebug \
    # && docker-php-ext-enable xdebug

COPY entrypoint.sh /entrypoint.sh
COPY ./wp-config.php ./wp-config.php
COPY ./.htaccess ./.htaccess
COPY ./conf.d/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
RUN chmod +x /entrypoint.sh && \
    chmod 444 ./.htaccess /usr/local/etc/php/conf.d/error_reporting.ini
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

COPY /flag.txt /flag.txt
RUN mv /flag.txt /`cat /proc/sys/kernel/random/uuid`.txt

# RUN cd /var/www/html/wp-content/plugins/ && wget https://downloads.wordpress.org/plugins/canvasio3d-light.zip -O app.zip && unzip app.zip && rm app.zip
COPY ./src/wp-content/plugins/canvasio3d-light /var/www/html/wp-content/plugins/canvasio3d-light

# Set ownership to root and make /var/www/html read-only
RUN chown root:root /var/www/html
# RUN chmod -R 555 /var/www/html

USER www-data

RUN mkdir -p /var/www/html/wp-content/uploads/$(date +%Y)/$(date +%m)/
COPY ./src/db.php /var/www/html/wp-content/db.php

USER root
COPY ./conf.d/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
COPY ./.htaccess /var/www/html/.htaccess
COPY --from=deps /home/bot /home/bot

ENTRYPOINT [ "/bin/bash", "/entrypoint.sh" ]
