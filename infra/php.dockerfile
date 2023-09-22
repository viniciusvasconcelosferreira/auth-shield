FROM php:8.2-fpm

# Instala as extensões necessárias para o Laravel e para o GD
RUN apt-get update && apt-get install -y \
        curl \
        git \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        libxml2-dev \
        libmemcached-dev  \
        libssl-dev  \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        redis-server \
        unzip \
        wget \
        zip \
        zlib1g-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instala as extensões PECL necessárias
RUN pecl install redis-5.3.7 \
	&& pecl install xdebug-3.2.1 \
	&& pecl install memcached-3.2.0

# Habilita as extensões PHP instaladas
RUN docker-php-ext-enable pdo_mysql memcached redis xdebug

# Instala o composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && unlink composer-setup.php

# Configura o timezone
RUN echo 'date.timezone="America/Sao_Paulo"' >> /usr/local/etc/php/conf.d/date.ini

# Configura o opcache
RUN echo 'opcache.enable=1' >> /usr/local/etc/php/conf.d/opcache.conf \
    && echo 'opcache.validate_timestamps=1' >> /usr/local/etc/php/conf.d/opcache.conf \
    && echo 'opcache.fast_shutdown=1' >> /usr/local/etc/php/conf.d/opcache

# Configura o redis
RUN echo "daemonize yes" >> /etc/redis/redis.conf
RUN echo "port 6379" >> /etc/redis/redis.conf
RUN echo "bind 0.0.0.0" >> /etc/redis/redis.conf

# Configura o xdebug
RUN echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.client_host = 127.0.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.client_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini

# Define o diretório de trabalho
WORKDIR /var/www/html

# Corrige as permissões da pasta
RUN chmod 777 -R /var/www/html