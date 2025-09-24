import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

// /** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#2563eb", // Azul MetricFlow
                secondary: "#1e293b", // Cinza escuro
                accent: "#f59e0b", // Laranja destaque
            },
        },
    },

    plugins: [forms],
};
