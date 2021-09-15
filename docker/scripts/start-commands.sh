#!/usr/bin/env bash

# Working directory
cd /var/www

# Allow PHP-FPM to start
sleep 5

# Execute Start commands
echo "Start commands: Executing"
php artisan view:pre-cache portal
