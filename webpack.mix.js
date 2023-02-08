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
const WebpackShellPlugin = require('webpack-shell-plugin-next');
mix.webpackConfig({
    mode: 'production',
    stats: {
        children: true,
    },
    plugins: [
        new WebpackShellPlugin({onBuildStart: {scripts: ['php artisan lang:js resources/js/vue-translations.json --json --quiet']}, onBuildEnd:[]}),
    ]
});
// if (mix.inProduction()) {
//     const CompressionPlugin = require('compression-webpack-plugin');
//
//     mix.webpackConfig({
//         plugins: [
//             new CompressionPlugin({
//                 filename: '[path].br[query]',
//                 algorithm: 'brotliCompress',
//                 test: /\.(js|css|html|svg)$/,
//                 compressionOptions: {level: 11},
//                 minRatio: 1,
//                 deleteOriginalAssets: false,
//             })
//         ],
//     });
// }

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass("resources/sass/app.scss", "public/css").options({
    postCss: [
        require('autoprefixer')({
            // browsers: ['last 40 versions'],
        })
    ]
})
    .sourceMaps().minify(['public/css/app.css', 'public/js/app.js'])
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ]);
