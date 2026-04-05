#!/bin/bash
set -euo pipefail
cd /var/www/html

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

php artisan package:discover --ansi 2>/dev/null || true

php artisan migrate --force --no-interaction

php artisan config:cache
php artisan route:cache
php artisan view:cache

PORT="${PORT:-80}"
if [[ -f /etc/apache2/ports.conf ]]; then
  sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
fi
if [[ -f /etc/apache2/sites-available/000-default.conf ]]; then
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

exec "$@"
