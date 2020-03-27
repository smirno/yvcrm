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

// Disable mix-manifest.json
Mix.manifest.refresh = function() {
    return void 0;
}

mix.setPublicPath('web/assets/');
mix.setResourceRoot('../');

mix.less('frontend/assets/vendor.less', 'web/assets/css/vendor.css');
mix.less('frontend/assets/app.less', 'web/assets/css/app.css');

mix.js('frontend/app/App.js', 'web/assets/js/app.js').extract([
	'vue', 'vuex', 'vue-router', 'axios', 'format-message'
]);