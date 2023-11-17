import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./resources/**/*.blade.php",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
    ],
    safelist: [
        'sm:max-w-sm',
        'sm:max-w-md',
        'sm:max-w-2xl',
        'md:max-w-lg',
        'md:max-w-xl',
        'xl:max-w-4xl',
        'xl:max-w-5xl',
        '2xl:max-w-6xl',
        '2xl:max-w-7xl',
        '3xl:max-w-8xl',
        '3xl:max-w-8xl',
        '4xl:max-w-10xl',
        '4xl:max-w-11xl',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
    plugins: [
        require('flowbite/plugin'),
        require('@tailwindcss/typography'),
    ],
};
