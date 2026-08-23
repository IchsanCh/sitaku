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

    echo "[entrypoint] Siap. Jalanin migration manual kalau perlu:"
    echo "  docker compose exec exavro php artisan migrate --force"
else
    echo "[entrypoint] Role: $CONTAINER_ROLE - nunggu vendor/autoload.php dari service app..."
    until [ -f vendor/autoload.php ]; do
        sleep 2
    done
fi

exec "$@"