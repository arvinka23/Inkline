import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    // Nur mit <html class="dark"> aktiv — sonst bleibt die App hell (kein schwarzer BG durch OS-Dark-Mode).
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', ...defaultTheme.fontFamily.sans],
                display: ['Fraunces', 'Georgia', 'serif'],
            },
            colors: {
                inkline: {
                    50: '#fff8f0',
                    100: '#ffedd5',
                    500: '#d97706',
                    700: '#b45309',
                    900: '#78350f',
                },
            },
        },
    },

    plugins: [forms, flowbite],
};
