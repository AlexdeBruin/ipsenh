FROM composer:1.7.1 AS composer

FROM php:7.1-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql

ADD . /var/www
ADD ./public /var/www/html

WORKDIR /var/www

RUN /usr/bin/composer install

RUN test -f .env || cp .env.example .env && php artisan key:generate

CMD php artisan migrate
CMD php artisan serve --host=0.0.0.0 --port=5000