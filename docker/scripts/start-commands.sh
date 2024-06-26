#!/usr/bin/env bash

# Working directory
cd /var/www

# Allow PHP-FPM to start
sleep 45

# Execute Start commands
echo "Start commands: Executing..."

# Run database migration
php artisan migrate:prod