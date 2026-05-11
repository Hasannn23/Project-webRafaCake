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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'rafa-pink': '#FDF2F8',      // Pink sangat muda (untuk background/section)
                'rafa-dark-pink': '#DB2777', // Pink tegas (untuk tombol/heading)
                'rafa-accent': '#F472B6',    // Pink sedang (untuk variasi)
            },
        },
    },

    plugins: [forms],
};
