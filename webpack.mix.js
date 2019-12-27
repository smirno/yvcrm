const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('frontend/app/App.js', 'web/js/app.js');
mix.less('frontend/assets/components.less', 'web/css/components.css');
mix.less('frontend/assets/app.less', 'web/css/app.css');
mix.setPublicPath('web/');