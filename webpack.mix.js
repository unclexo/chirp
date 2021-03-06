const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

mix.options({
        postCss: [tailwindcss('tailwind.config.js')],
        processCssUrls: false,
    })
    .sass('resources/sass/app.sass', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .version()
