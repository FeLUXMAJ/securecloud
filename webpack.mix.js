const { mix } = require('laravel-mix');


/* ----------------------- fonts ----------------------- */
mix.copy('node_modules/roboto-fontface/fonts/Roboto/*', 'public/fonts/Roboto')
   .copy('node_modules/material-design-icons-iconfont/dist/fonts/MaterialIcons-Regular.*', 'public/fonts/Material-Icons');


/* ------------------------ js ------------------------- */
mix.js([
    'resources/assets/js/app.js',
    'node_modules/sweetalert/dist/sweetalert.min.js'
], 'public/js');

mix.js('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.js');

/* ----------------------- less ------------------------ */
mix.less('resources/assets/less/app.less', 'public/css');