#!/usr/bin/env bash

# Export Docker image Tag
if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
else
    BRANCH="${TRAVIS_BRANCH}"
fi
export BRANCH

# Build new images & start fresh container instances
docker-compose -f docker-compose-dev.yml up -d --build

# Run phpunit inside Docker 'app' container
docker exec -it app ./vendor/bin/phpunit