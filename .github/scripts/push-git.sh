#!/usr/bin/env bash

# exit when any command fails
set -e

# Retrieve the version number
VERSION="$(head -n 1 version.txt)"

docker push stephenneal/laravel-boilerplate:"${VERSION//"'"}"