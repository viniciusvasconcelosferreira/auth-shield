FROM php:8.2-fpm

# Instala as extensões necessárias para o Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    redis-server \
    xdebug \
    memcached \
    zip \
    git \
    curl \
    libssl-dev \
    unzip \
    wget

# Instala o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto para o container
COPY . .

# Executa o composer para instalar as dependências
RUN composer install

# Inicia o servidor PHP-FPM
CMD ["php-fpm"]

# Configura o redis
RUN echo "daemonize yes" >> /etc/redis/redis.conf
RUN echo "port 6379" >> /etc/redis/redis.conf
RUN echo "bind 0.0.0.0" >> /etc/redis/redis.conf

# Configura o xdebug
RUN echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_autostart = 1" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_host = 127.0.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini

# Configura o timezone
RUN echo "date.timezone = America/Sao_Paulo" >> /usr/local/etc/php/conf.d/timezone.ini

# Configura o opcache
RUN echo "opcache.enable = 1" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.memory_consumption = 128" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.max_accelerated_files = 20000" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.revalidate_freq = 1" >> /usr/local/etc/php/conf.d/opcache.ini
RUN echo "opcache.fast_shutdown = 1" >> /usr/local/etc/php/conf.d/opcache.ini
