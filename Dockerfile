FROM php:8.4-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    default-mysql-client \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring zip exif pcntl curl intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node.js (dibutuhin buat build asset Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP tuning (opcache + upload size, samain sama nginx client_max_body_size)
COPY docker/opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/uploads.ini /usr/local/etc/php/conf.d/zz-uploads.ini

WORKDIR /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]