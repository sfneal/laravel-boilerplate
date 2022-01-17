const mix = require('laravel-mix');

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

// Set public path to avoid file not found errors
mix.setPublicPath('./public');

// Application assets
mix
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .sourceMaps();

// Add versions
if (mix.inProduction()) {
    mix.version();
}
