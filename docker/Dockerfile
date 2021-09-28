FROM php:8.0.9-fpm

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql

# JIT enable
RUN docker-php-ext-install opcache
RUN echo 'opcache.enable_cli=1\nopcache.jit_buffer_size=50M\nopcache.jit=tracing\n' >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apt-get update && apt-get install -y git

# gd for image processing
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd


WORKDIR /var/www

