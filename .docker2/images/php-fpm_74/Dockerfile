FROM php:7.4.25-fpm-alpine3.14

LABEL author="Sergey Bernikov <saberkut@gmail.com>"
LABEL version="1.0"
LABEL description="This image contains PHP modules and configurations to run ME:PROJECT"

RUN apk add --update --no-cache autoconf gcc make g++ icu-dev zlib-dev bzip2-dev libpng-dev gettext-dev libzip-dev \
    imagemagick-dev libmcrypt-dev imap-dev openldap-dev libxslt-dev rabbitmq-c-dev tesseract-ocr composer \
    && pecl install zip \
    && pecl install xdebug \
    && printf "\n" | pecl install amqp \
    && printf "\n" | pecl install apcu \
    && printf "\n" | pecl install imagick \
    && printf "\n" | pecl install mcrypt \
    && docker-php-ext-enable amqp apcu imagick mcrypt xdebug zip \
    && docker-php-ext-install bz2 calendar exif gd gettext imap intl ldap mysqli pcntl pdo_mysql shmop sockets \
    sysvmsg sysvsem sysvshm xsl opcache
