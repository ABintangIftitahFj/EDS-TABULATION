import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                pixel: ['"VT323"', 'monospace'],
            },
            colors: {
                'england-red': '#CF142B',
                'england-blue': '#00247D',
                'soft-pink': '#FFB7D5',
                'pixel-shadow': '#D9D9D9',
            },
            boxShadow: {
                'pixel': '4px 4px 0px 0px #D9D9D9',
                'pixel-sm': '2px 2px 0px 0px #D9D9D9',
                'pixel-lg': '6px 6px 0px 0px #D9D9D9',
            },
        },
    },

    plugins: [forms],
};
