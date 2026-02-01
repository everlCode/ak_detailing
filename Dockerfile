FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем необходимые PHP-расширения, добавляем intl
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
