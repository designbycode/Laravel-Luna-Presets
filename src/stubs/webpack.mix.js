let mix = require('laravel-mix');



mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/style.sass', 'public/css');
