let mix = require('laravel-mix');

mix .js('resources/js/deccl.js', 'public/js/')
    .sass('resources/css/deccl.scss', 'public/css/')
    .version()
    .disableNotifications();