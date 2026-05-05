const mix = require('laravel-mix');
const webpack = require('webpack');

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

mix.override((webpackConfig) => {
    if (!webpackConfig || !Array.isArray(webpackConfig.plugins)) {
        return;
    }

    webpackConfig.plugins = webpackConfig.plugins.filter((plugin) => {
        const ctorName = plugin && plugin.constructor && plugin.constructor.name;

        if (ctorName && ctorName.toLowerCase().includes('webpackbar')) {
            return false;
        }

        if (ctorName === 'ProgressPlugin') {
            const opts = plugin && plugin.options;
            if (opts && (Object.prototype.hasOwnProperty.call(opts, 'name') || Object.prototype.hasOwnProperty.call(opts, 'color') || Object.prototype.hasOwnProperty.call(opts, 'reporter') || Object.prototype.hasOwnProperty.call(opts, 'reporters'))) {
                return false;
            }
        }

        return true;
    });

    webpackConfig.plugins.push(new webpack.ProgressPlugin());
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
