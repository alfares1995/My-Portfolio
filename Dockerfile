# syntax=docker/dockerfile:1

# ---------- Stage 1: build frontend assets (Vite) ----------
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---------- Stage 2: install PHP dependencies ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
COPY app ./app
COPY bootstrap ./bootstrap
COPY database ./database
COPY artisan ./artisan
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts

# ---------- Stage 3: runtime image (php-fpm + nginx via supervisord) ----------
FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor sqlite-dev $PHPIZE_DEPS icu-dev oniguruma-dev libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql bcmath intl zip opcache pcntl \
    && apk del $PHPIZE_DEPS

# Reasonable production PHP/opcache defaults (uploads used for project/thumbnail images)
RUN { \
    echo 'upload_max_filesize=20M'; \
    echo 'post_max_size=20M'; \
    echo 'opcache.enable=1'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.memory_consumption=192'; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

COPY docker/nginx-site.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
