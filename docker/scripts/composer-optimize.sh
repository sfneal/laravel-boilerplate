#!/usr/bin/env bash

chmod=${1}
list_routes=${2}

# Clean up bootstrap
if [[ ${chmod} == true ]]; then
    chown -R www-data:www-data /var/www/storage
    chmod -R 755 /var/www/storage
    chmod -R 777 /var/www/bootstrap/cache
fi

# Finish composer
composer dump-autoload --optimize
composer run-script post-install-cmd
php artisan optimize
php artisan config:clear


# Cache routes
php artisan route:cache

# List routes
if [[ ${list_routes} == true ]]; then
    php artisan route:list
fi
