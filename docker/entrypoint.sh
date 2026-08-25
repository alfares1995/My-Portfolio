#!/bin/sh
set -e

cd /var/www/html

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views \
    storage/logs storage/app/public storage/app/database bootstrap/cache
[ -f storage/app/database/database.sqlite ] || touch storage/app/database/database.sqlite
chown -R www-data:www-data storage bootstrap/cache
chmod -R a+rX storage/app/public

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link || true

exec "$@"
