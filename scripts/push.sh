#!/usr/bin/env bash

# exit when any command fails
set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

# Retrieve the version number
VERSION="$(head -n 1 version.txt)"

# Run the build script
sh "${DIR}"/build.sh prod

docker push stephenneal/laravel-boilerplate:"${VERSION//"'"}"