#!/usr/bin/env bash

# exit when any command fails
set -e

# Retrieve the version number
VERSION="$(head -n 1 version.txt)"

# Declare the 'environment' ('dev', 'production')
ENV=${1-"dev"}

# Declare PHP Composer tag
PHP_COMPOSER_TAG=${3:-"8.3-v2"}

# Declare PHP Laravel tag
PHP_LARAVEL_TAG=${4:-"8.3-fpm-v3"}


# Set params for a 'development' build
if [[ "${ENV}" == "dev" ]]; then
  COMPOSER_FLAGS="--no-scripts --no-autoloader"
  YARN_ENV="development"
  ENV_FILE_NAME=".env.dev"

# Set params for a 'production' build
else
  COMPOSER_FLAGS="--no-scripts --no-autoloader --no-dev"
  YARN_ENV="production"
  ENV_FILE_NAME=".env"
fi


# Build app Docker image
docker build \
	--progress plain \
    -t stephenneal/laravel-boilerplate:"${VERSION//}" \
    --build-arg composer_flags="${COMPOSER_FLAGS}" \
    --build-arg yarn_env="${YARN_ENV}" \
    --build-arg env_file_name="${ENV_FILE_NAME}" \
    --build-arg php_composer_tag="${PHP_COMPOSER_TAG}" \
    --build-arg php_laravel_tag="${PHP_LARAVEL_TAG}" \
    .

docker image inspect stephenneal/laravel-boilerplate:"${VERSION//}"