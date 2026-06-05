FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libicu-dev \
    libzip-dev zip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# ВАЖНО: configure gd
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl  zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install && npm install

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
