const mix = require('laravel-mix');
require('laravel-mix-purgecss');
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    // Set public path to avoid file not found errors
    .setPublicPath('./public')

    // Application assets
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .sourceMaps();

// Production config
if (mix.inProduction()) {
    // Add versions
    mix.version();

    // Purge CSS
    mix.purgeCss({
        extend: {
            content: [
                path.join(__dirname, 'public/js/app.js'),
            ],
        },
    });
}
