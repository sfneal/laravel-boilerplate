#!/usr/bin/env bash

# Determine if the version bump is a major, minor or patch
while :; do
    case $1 in
        -ma|--major) type="major"
        ;;
        -mi|--minor) type="minor"
        ;;
        -p|--patch) type="patch"
        ;;
        *) break
    esac
    shift
done

# Retrieve the version number
VERSION="$(head -n 1 version.txt)"

# Get the new version number
# https://github.com/fsaintjacques/semver-tool
BUMP="$(./scripts/version/semver bump ${type} ${VERSION})"

message="BUMP ${type} version (${VERSION} --> ${BUMP})"

echo "${message}"

# Replace the version numbers
# https://stackoverflow.com/questions/525592/find-and-replace-inside-a-text-file-from-a-bash-command
perl -pi -e "s/${VERSION}/${BUMP}/g" ./version.txt
perl -pi -e "s/${VERSION}/${BUMP}/g" ./docker-compose.yml
perl -pi -e "s/${VERSION}/${BUMP}/g" ./docker-compose-tests.yml
perl -pi -e "s/${VERSION}/${BUMP}/g" ./docker-compose-dev.yml
perl -pi -e "s/${VERSION}/${BUMP}/g" ./docker-compose-dev-db.yml
perl -pi -e "s/${VERSION}/${BUMP}/g" ./docker-compose-dev-node.yml

# Commit to git
git commit -m "${message}" ./version.txt ./docker-compose.yml ./docker-compose-dev.yml ./docker-compose-tests.yml ./docker-compose-dev-db.yml ./docker-compose-dev-node.yml