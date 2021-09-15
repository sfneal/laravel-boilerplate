#!/usr/bin/env bash

# Declare the 'boot' mode ('dev', 'upgrade', 'build')
mode=${1-"dev"}

# Declare the log to follow ('query' or 'laravel')
log=${2-"query"}


# Check if 'upgrade' scripts should be run
if [[ "${mode}" == "upgrade" ]]; then
  brew upgrade
  composer update --no-cache
fi

# Shut down currently running containers
(docker compose -f docker-compose-dev.yml build && echo "Stopping running containers before creating service...") \
  & docker compose -f docker-compose-dev.yml down -v --remove-orphans > /dev/null 2>&1

# Start fresh container instances
docker compose -f docker-compose-dev.yml up -d

docker exec -it app tail -f storage/logs/${log}.log