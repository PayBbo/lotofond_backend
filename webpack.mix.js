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
// const { VueLoaderPlugin } = require('vue-loader');
// mix.webpackConfig({
    // stats: {
    //     children: true,
    // },
//     mode: 'development',
//     module: {
//         rules: [
//             {
//                 test: /\.vue$/,
//                 loader: 'vue-loader'
//             },
//             // // this will apply to both plain `.js` files
//             // // AND `<script>` blocks in `.vue` files
//             {
//                 test: /\.js$/,
//                 loader: 'babel-loader',
//                 exclude: file => (
//                     /node_modules/.test(file) &&
//                     !/\.vue\.js/.test(file)
//                 )
//             },
//             // // this will apply to both plain `.css` files
//             // // AND `<style>` blocks in `.vue` files
//             {
//                 test: /\.css$/,
//                 use: [
//                     'vue-style-loader',
//                     'sass-loader',
//                     // 'css-loader'
//                 ]
//             }
//         ]
//     },
//     plugins: [
//         // make sure to include the plugin for the magic
//         new VueLoaderPlugin()
//     ]
//
// });
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass("resources/sass/app.scss", "public/css");
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ]);
