FROM php:8.1-fpm

RUN export http_proxy=http://127.0.0.1:10809 https_proxy=http://127.0.0.1:10809

WORKDIR /app

COPY . /app

RUN apt-get update -y && \
    apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libxml2-dev \
    libc-client-dev \
    libkrb5-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libz-dev \
    libzip-dev \
    supervisor \
    libcurl4-openssl-dev \
    nano \
    cron && \
    apt-get clean -y && \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update -y && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

EXPOSE 80

CMD ["php", "ConsoleCommand", "migrate"]
