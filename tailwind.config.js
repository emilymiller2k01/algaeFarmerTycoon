import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.{js,ts,jsx,tsx,mdx,php}',
    ],

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            green : {
                DEFAULT: "#42FF00",
                dark: "#42FF0060",
            },
            yellow : {
                DEFAULT: "rgb(255,229,0)",
                dark: "rgb(255,229,0,0.8)",
            },
            grey: {
                DEFAULT: "#FFFFFF10",
                dark: "#292929",
                light: "#FFFFFF20",
            },
            white: {
                DEFAULT: "#FFFFFF",
            },
            black: {
                DEFAULT: "rgb(14,14,18)",
            },
        },
        extend: {
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
            // backgroundImage: {
            //     'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
            //     'gradient-conic':
            //         'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            // },
        },
    },

    plugins: [forms],
};
