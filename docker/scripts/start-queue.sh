#!/usr/bin/env bash


# Create log file directory
chmod 777 /var/log/supervisor

# Make supervisor directory is available
mkdir -p /var/run/supervisor

# Start queue workers
sudo unbuffer /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf