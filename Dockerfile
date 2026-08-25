# syntax=docker/dockerfile:1

# ---------- Stage 1: install PHP deps + build frontend assets ----------
# Needs PHP (not just Node) because the wayfinder vite plugin shells out to
# `php artisan wayfinder:generate` during `npm run build`.
FROM php:8.3-cli-alpine AS build
RUN apk add --no-cache nodejs npm sqlite-dev $PHPIZE_DEPS icu-dev oniguruma-dev libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql bcmath intl zip mbstring \
    && apk del $PHPIZE_DEPS
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs storage/app/public bootstrap/cache
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-scripts
RUN npm install && npm run build

# ---------- Stage 2: runtime image (php-fpm + nginx via supervisord) ----------
FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor sqlite-dev $PHPIZE_DEPS icu-dev oniguruma-dev libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql bcmath intl zip mbstring opcache pcntl \
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
COPY --from=build /app/vendor ./vendor
COPY --from=build /app/public/build ./public/build

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

