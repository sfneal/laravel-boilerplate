#!/usr/bin/env bash

# Working directory
cd /var/www

# Create log file to prevent error
touch /var/www/storage/logs/laravel.log
touch /var/www/storage/logs/worker.log
touch /var/www/storage/logs/query.log
touch /var/www/storage/logs/traffic.log

# Set permissions for log storage
chown -R $USER:www-data /var/www/storage
chown -R $USER:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Clear config and cache
php artisan env


# Parse command arguments
while :; do
    case $1 in
        -a|--app) app=true
        ;;
        -q|--queue) queue=true
        ;;
        -c|--commands) commands=true
        ;;
        -s|--schedule) schedule=true
        ;;
        *) break
    esac
    shift
done

# Start queue worker
if [[ "$queue" == true ]]; then
    sh /var/www/scripts/start-queue.sh &
fi

# Execute Start Commands
if [[ "$commands" == true ]]; then
    sh /var/www/scripts/start-commands.sh &
fi

# Start scheduler
if [[ "$schedule" == true ]]; then
    sh /var/www/scripts/start-schedule.sh &
fi

if [[ "$app" == true ]]; then
    # Start PHP FPM
    php-fpm
else
    # Prevent exit
    tail -f /dev/null
fi