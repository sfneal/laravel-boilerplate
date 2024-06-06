#!/usr/bin/env bash

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
docker compose -f docker-compose-tests.yml build --progress plain

# Start fresh container instances
docker compose -f docker-compose-tests.yml up -d

# Wait for database connection to become available
docker exec app php artisan db:wait