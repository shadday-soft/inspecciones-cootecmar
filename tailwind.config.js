import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['InterVariable', ...defaultTheme.fontFamily.sans],
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],

            },
            colors: {
                primary: {
                    DEFAULT: "#2E3092",
                    light: "#eaf1ff",
                    "dark-light": "rgba(67,97,238,.15)",
                },
                GECON: { DEFAULT: "#22c55e" },
                secondary: {
                    DEFAULT: "#dadafc",
                    light: "#ebe4f7",
                    "dark-light": "rgb(128 93 202 / 15%)",
                },
                success: {
                    DEFAULT: "#00ab55",
                    light: "#ddf5f0",
                    "dark-light": "rgba(0,171,85,.15)",
                },
                danger: {
                    DEFAULT: "#DC2626",
                    light: "#fff5f5",
                    "dark-light": "rgba(231,81,90,.15)",
                },
                warning: {
                    DEFAULT: "#f97b38",
                    light: "#fff9ed",
                    "dark-light": "rgba(226,160,63,.15)",
                },
                info: {
                    DEFAULT: "#2196f3",
                    light: "#e7f7ff",
                    "dark-light": "rgba(33,150,243,.15)",
                },
                dark: {
                    DEFAULT: "#3b3f5c",
                    light: "#eaeaec",
                    "dark-light": "rgba(59,63,92,.15)",
                },
                black: {
                    DEFAULT: "#0e1726",
                    light: "#e3e4eb",
                    "dark-light": "rgba(14,23,38,.15)",
                },
                white: {
                    DEFAULT: "#ffffff",
                    light: "#e0e6ed",
                    dark: "#888ea8",
                },
            },
        },
    },

    plugins: [forms, typography, require('tailwindcss-primeui')],
};
