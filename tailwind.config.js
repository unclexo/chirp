module.exports = {
    purge: {
        content: [
            '**/*.blade.php',
            '**/*.vue',
        ],
        options: {
            whitelist: [
                //
            ],
        },
    },

    theme: {
        container: {
            center: true,
            padding: '1rem',
        },

        extend: {
            fontFamily: {
                sans: ['Montserrat', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
            },

            opacity: {
                5: '0.05',
                10: '0.1',
                15: '0.15',
                20: '0.2',
                30: '0.3',
                35: '0.35',
                40: '0.4',
            },
        },

        screens: {
            tiny: '375px',
            xs: '414px',
            sm: '480px',
            md: '768px',
            lg: '1024px',
        },
    },

    variants: {
        backgroundOpacity: ['responsive', 'hover', 'group-hover', 'focus'],
    },
}
