# Base PHP image tags
ARG php_composer_tag=8.1-v2
ARG php_laravel_tag=8.1-fpm-v3
ARG node_yarn_tag=v4



# Build temp image to copy static files
FROM stephenneal/php-composer:${php_composer_tag} AS static

# Set working directory
WORKDIR /var/www

# Copy static files
COPY ["server.php", "artisan", "phpunit.xml", "README.md", "/var/www/"]

# Copy startup script
COPY docker/scripts /var/www/scripts/

# Copy version & changelog files
COPY ["version.txt", "changelog.txt", "/var/www/"]



# Build temp image to install composer dependencies
FROM stephenneal/php-composer:${php_composer_tag} AS composer

# Set working directory
WORKDIR /var/www

# Laravel .env file
ARG env_file_name=.env

# Composer install flags
ARG composer_flags="--no-scripts --no-autoloader --no-dev"

# Copy composer & yarn package files
COPY ["composer.json", "composer.lock", "/var/www/"]

# Install composer dependencies
RUN composer install ${composer_flags}

# Copy env file
COPY ${env_file_name} /var/www/.env

# Copy 'relatively' static source code
COPY database  /var/www/database/
COPY tests  /var/www/tests/
COPY public  /var/www/public/
COPY config  /var/www/config/
COPY storage  /var/www/storage/
COPY bootstrap  /var/www/bootstrap/

# Copy 'dynamic' source code
COPY routes /var/www/routes/
COPY resources /var/www/resources/
COPY app /var/www/app/

# Copy files from 'static' image
COPY --from=static /var/www .

# Clean up bootstrap & Finish composer
RUN /var/www/scripts/composer-optimize.sh true



# NodeJS package installer
FROM stephenneal/node-yarn:${node_yarn_tag} AS node

# Yarn install environment ('production' or 'development')
ARG yarn_env="production"

# Copy npm package files
COPY ["package.json", "yarn.lock", "/var/www/"]

# Install node_modules
RUN yarn install

# Copy webpack files
COPY ["webpack.mix.js", "/var/www/"]

# Copy relevant files from base image
COPY --from=composer /var/www/public /var/www/public/
COPY --from=composer /var/www/resources /var/www/resources/

# Compile webpack assets
RUN yarn run ${yarn_env}

# Remove node_modules directory
RUN rm -r /var/www/node_modules



# Build PHP-fpm running image
FROM stephenneal/php-laravel:${php_laravel_tag} as fpm
WORKDIR /var/www
EXPOSE 9000
VOLUME ["/var/www"]

# Copy Supervisor configs
COPY docker/supervisor /etc/supervisor/

# Copy relevant files from base image
COPY --from=composer /var/www .
COPY --from=node /var/www .

ENTRYPOINT ["/bin/bash", "/var/www/scripts/start.sh"]
CMD ["--app", "--queue", "--schedule"]