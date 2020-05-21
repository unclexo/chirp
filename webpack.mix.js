const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

require('laravel-mix-purgecss')

mix.options({
        postCss: [tailwindcss('tailwind.config.js')],
        processCssUrls: false,
    })
    .purgeCss({ whitelistPatterns: [] })
    .sass('resources/sass/app.sass', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .version()
