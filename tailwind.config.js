/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Views/**/*.php",
        "./app/Views/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Geist Mono', 'monospace'],
                mono: ['Geist Mono', 'monospace'],
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: '65ch',
                        color: '#333',
                        a: {
                            color: '#3182ce',
                            '&:hover': {
                                color: '#2c5282',
                            },
                        },
                        fontFamily: {
                            sans: ['Geist Mono', 'monospace'],
                        },
                    },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
} 