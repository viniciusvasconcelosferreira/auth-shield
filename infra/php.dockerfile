# Imagem base PHP 8.2 FPM
FROM php:8.2-fpm

# Adiciona o docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Torna o script executável
RUN chmod +x /usr/local/bin/install-php-extensions && sync

# Instala dependências temporárias e extensões PHP necessárias
RUN apt-get update && apt-get install -y --no-install-recommends \
        curl \
        git \
        redis-server \
        unzip \
        wget \
        zip \
        build-essential \
        autoconf \
        dpkg-dev \
        file \
        gcc \
        libc-dev \
        make \
        pkg-config \
    && install-php-extensions \
        gd \
        intl \
        opcache \
        pdo_mysql \
        mysqli \
        zip \
        redis \
        xdebug \
        memcached \
        pcntl \
    && apt-get purge -y --auto-remove \
        build-essential \
        autoconf \
        dpkg-dev \
        file \
        gcc \
        libc-dev \
        make \
        pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura o timezone
RUN echo 'date.timezone="America/Sao_Paulo"' > /usr/local/etc/php/conf.d/date.ini

# Configurações adicionais de opcache
RUN echo 'opcache.enable=1' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.validate_timestamps=1' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.fast_shutdown=1' >> /usr/local/etc/php/conf.d/opcache.ini

# Configura o Redis
RUN echo "daemonize yes" >> /etc/redis/redis.conf \
    && echo "port 6379" >> /etc/redis/redis.conf \
    && echo "bind 0.0.0.0" >> /etc/redis/redis.conf

# Configura o Xdebug
RUN echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host = 127.0.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini

# Define o diretório de trabalho
WORKDIR /var/www/html

# Corrige as permissões da pasta
RUN chmod -R 777 /var/www/html
