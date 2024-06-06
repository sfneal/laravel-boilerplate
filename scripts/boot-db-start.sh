#!/usr/bin/env bash

# Declare the log to follow ('query' or 'laravel')
log=${1-"query"}

# Export Docker image Tag
if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
    replace='/'
    replacewith='-'
    BRANCH="${BRANCH/${replace}/${replacewith}}"
    BRANCH="${BRANCH/${replace}/${replacewith}}"
else
    BRANCH="${TRAVIS_BRANCH}"
fi
export BRANCH

# Shut down currently running containers
composer down

# Build new containers
docker compose -f docker-compose-dev-db.yml build --progress plain

# Start fresh container instances
docker compose -f docker-compose-dev-db.yml up -d

# Artisan Migration
docker exec app php artisan db:wait