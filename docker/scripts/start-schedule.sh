#!/usr/bin/env bash

# Working directory
cd /var/www

# Run the scheduler every 60 seconds
while [ true ]
do
  php /var/www/artisan schedule:run --verbose --no-interaction &
  sleep 60
done

echo "Schedule worker: Started"