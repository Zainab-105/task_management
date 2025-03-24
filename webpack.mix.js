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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();

    // Admin
// mix.scripts('public/admin/js/custom.js', 'public/js/custom.js');
mix.scripts('public/assets/plugins/global/plugins.bundle.js', 'public/js/plugins.bundle.js');
mix.scripts('public/assets/plugins/custom/prismjs/prismjs.bundle.js', 'public/js/prismjs.bundle.js');
mix.scripts('public/assets/js/scripts.bundle.js', 'public/js/scripts.bundle.js');
mix.scripts('public/assets/js/pages/widgets.js', 'public/js/widgets.js');
// mix.scripts('public/admin/js/custom_validations.js', 'public/js/custom_validations.js');
mix.scripts('public/assets/plugins/custom/datatables/datatables.bundle.js', 'public/js/datatables.bundle.js');


mix.styles([
    'public/assets/css/themes/layout/header/base/light.css',
	'public/assets/css/themes/layout/header/menu/light.css',
	'public/assets/css/themes/layout/brand/dark.css',
	'public/assets/css/themes/layout/aside/dark.css'
], 'public/css/theme.css');

mix.styles('public/assets/plugins/custom/prismjs/prismjs.bundle.css', 'public/css/prismjs.bundle.css');
mix.styles('public/assets/css/style.bundle.css', 'public/css/style.bundle.css');
