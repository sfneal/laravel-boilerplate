#!/usr/bin/env bash

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
docker compose -f docker-compose-dev-db.yml build --progress plain

# Start fresh container instances
docker compose -f docker-compose-dev-db.yml up -d

# Artisan Migration
sleep 20
docker exec app php artisan migrate --seed

# Run phpunit inside Docker 'app' container
docker exec -it app ./vendor/bin/phpunit
