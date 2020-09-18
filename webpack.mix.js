let mix = require('laravel-mix');

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

// mix.js('resources/js/app.js', 'public/js')
// 	.js('resources/js/my_jquery.js', 'public/js')
//   .sass('resources/sass/app.scss', 'public/css')
//   .sass('resources/sass/admin.scss', 'public/css');


mix
  .setPublicPath('public/build')
  .setResourceRoot('build')
  .js('resources/assets/js/app.js', 'js')
  .sass('resources/assets/sass/app.scss', 'css')
  .sass('resources/assets/sass/my_style.scss', 'css')
  .version();