#!/usr/bin/env bash

# Declare the 'boot' mode ('dev', 'upgrade', 'build')
mode=${1-"dev"}

# Declare the log to follow ('query' or 'laravel')
log=${2-"query"}

# Export Docker image Tag
if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
else
    BRANCH="${TRAVIS_BRANCH}"
fi
export BRANCH

# Shut down currently running containers
composer down

# Build new containers
docker compose -f docker-compose-dev.yml build --progress plain

# Start fresh container instances
docker compose -f docker-compose-dev.yml up -d

docker exec -it app tail -f storage/logs/${log}.log