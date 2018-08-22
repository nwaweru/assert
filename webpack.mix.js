let mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            jquery: 'jquery/src/jquery'
        }
    }
});

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');

mix.styles([
    'resources/assets/css/core-ui.css',
    'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css'
], 'public/css/app.css');

mix.js([
    'resources/assets/js/app.js',
    'node_modules/pace-js/pace.min.js',
    'node_modules/chart.js/dist/Chart.min.js',
    'node_modules/datatables.net/js/jquery.dataTables.js',
    'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js'
], 'public/js/app.js');
