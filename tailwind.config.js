import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Agenda schedule uses dynamic Tailwind classes by index
    safelist: [
        'bg-[#fef9c3]',
        'bg-[#ffedd5]',
        'bg-[#fed7aa]',
        'bg-[#fecaca]',
        'bg-[#e9d5ff]',
        'bg-[#fce7f3]',
        'bg-[#bbf7d0]',
        'bg-[#99f6e4]',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
