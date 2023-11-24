FROM php:8.1-fpm
RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install pdo pdo_mysql \
&& pecl install xdebug \
&& docker-php-ext-enable xdebug

COPY ./conf.d/xdebug.ini "${PHP_INI_DIR}/conf.d"
