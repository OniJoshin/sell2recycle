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
            brand: {
                DEFAULT: '#32B44A',       // Primary brand green
                dark: '#278A39',          // Optional darker variant
                light: '#C9F3D4',         // Optional light background
            },
            accent: {
                dark: '#041832',          // Navy blue for contrast (text, footer)
                light: '#4EAED3',         // Sky blue for supporting visuals
            }
        },

        },
        
    },

    plugins: [forms],
};
