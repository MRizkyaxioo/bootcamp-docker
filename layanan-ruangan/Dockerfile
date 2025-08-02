# stage 1:membangun depedensi
FROM composer:latest AS builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts
COPY . .

# stage 2: build final image yang bersih
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html
# install ekstensi php yang dibutuhkan saat runtime
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libzip-dev \
    jpeg-dev \
    freetype-dev \
    oniguruma-dev
# konfigurasi dan install ekstensi gd yang lengkap
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd
# install ekstensi php umum
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip
# salin composer executable agar bisa digunakan di dalam container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# salin hanya hasil akhir dari stragre builder
COPY --from=builder /app .
RUN chown -R www-data:www-data /var/www/html
EXPOSE 9000
CMD ["php-fpm"]
