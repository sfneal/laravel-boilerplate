#!/usr/bin/env bash

# exit when any command fails
set -e

# todo: move this functionality into a Docker container so Python & awsebcli don't need to be installed locally
# Declare the AWS Elastic Beanstalk environment
AWS_EB_ENV=${2-"laravel-boilerplate"}

# Declare the AWS Elastic Beanstalk version description
AWS_EB_VERSION_DESC=${3-"EB-CLI Deploy (Amazon Linux 2/3.4.2)"}

# Declare the Docker image tag
DOCKER_TAG="$(head -n 1 version.txt)"

# Run the build & push scripts
sh scripts/build.sh prod
sh scripts/push.sh > /dev/null 2>&1 & echo "Silently pushing Docker image [${DOCKER_TAG}]..."

# Create the deployment directory (./aws-eb-deployment) if it doesn't exist
mkdir -p ".aws-eb-deployment"

# Copy Dockerrun.aws.json file to deployment directory
cp docker-compose.yml .aws-eb-deployment/docker-compose.yml

# Change directory to deployment directory
cd ".aws-eb-deployment"

# Execute deployment command
time eb deploy "${AWS_EB_ENV}" \
    --profile sfneal \
    --label "${DOCKER_TAG}"\
    --message "${AWS_EB_VERSION_DESC}" \
    --timeout 45