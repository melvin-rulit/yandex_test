FROM php:8.3-fpm-bookworm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sudo \
    libsqlite3-dev \
    mariadb-client \
    libsodium-dev \
    libc-client-dev \
    libkrb5-dev \
    libzip-dev \
    libpq-dev \
    nano \
    libssl-dev \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && node -v && npm -v

RUN docker-php-ext-install \
    sockets \
    sodium \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    soap \
    zip \
    mysqli \
    pdo_mysql \
    dom

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY ./src /var/www

RUN npm install

COPY ./docker/php/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]