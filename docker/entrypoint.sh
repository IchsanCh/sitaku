#!/bin/sh
set -e

cd /var/www/html

if [ "$CONTAINER_ROLE" = "app" ]; then
    echo "[entrypoint] Role: app - install dependencies & build assets"

    COMPOSER_FLAGS="--no-interaction --prefer-dist --optimize-autoloader"
    if [ "$APP_ENV" = "production" ]; then
        COMPOSER_FLAGS="$COMPOSER_FLAGS --no-dev"
    fi
    composer install $COMPOSER_FLAGS

    if [ -f package.json ]; then
        npm ci
        npm run build
    fi

    if [ ! -L public/storage ]; then
        php artisan storage:link
    fi

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # chown/chmod HARUS di belakang, bukan di depan -- 3 command artisan di atas
    # jalan sebagai root (belum ada user-switch di entrypoint ini) dan bikin file
    # cache baru (view/route/config), jadi kalau chown-nya duluan, file baru dari
    # command2 itu balik lagi jadi punya root, nge-undo chown-nya. Ujung-ujungnya
    # php-fpm (jalan sebagai www-data) gak bisa nulis/update view cache pas ada
    # blade yang berubah -> Permission Denied pas ada request.
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache

    echo "[entrypoint] Siap. Jalanin migration manual kalau perlu:"
    echo "  docker compose exec exavro php artisan migrate --force"
else
    echo "[entrypoint] Role: $CONTAINER_ROLE - nunggu vendor/autoload.php dari service app..."
    until [ -f vendor/autoload.php ]; do
        sleep 2
    done

    # Container ini (queue/reverb/scheduler) jalan sebagai root juga -- kalau
    # proses di dalemnya bikin file baru di storage/ (mis. lock file punya
    # scheduler tiap kali schedule:run jalan), file itu bakal root-owned dan
    # bisa numpuk masalah permission yang sama kayak di atas. Disamain lagi
    # di sini sebagai jaga-jaga di setiap start container.
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
fi

exec "$@"