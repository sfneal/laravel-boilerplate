#!/usr/bin/env bash

brew upgrade
composer update --no-cache
yarn upgrade
yarn run production