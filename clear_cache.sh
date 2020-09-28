#!/bin/sh
docker-compose exec app bash -c "
php artisan cache:clear &&
php artisan config:clear &&
php artisan config:cache &&
php artisan route:clear &&
php artisan view:clear &&
php artisan clear-compiled &&
php artisan optimize &&
composer dump-autoload &&
rm -f bootstrap/cache/config.php"
