import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        //Preline
        'node_modules/preline/dist/*.js',

        //PowerGrid
        './app/PowerGridThemes/**/*.php',
        './app/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',

        //Wire Elements Modal
        './vendor/wire-elements/modal/**/*.blade.php',
        './vendor/wire-elements/modal/src/ModalComponent.php',

        //Toastr
        './resources/**/*.blade.php',
        './vendor/masmerise/livewire-toaster/resources/views/*.blade.php',
    ],

    presets: [
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"), 
    ],

    theme: {
        extend: {
            zIndex: {
                '60': '60',
                '70': '70',
                '80': '80',
              },
              
            colors: {
                'primary': {
                    '50': '#edf8ff',
                    '100': '#d6eeff',
                    '200': '#b6e3ff',
                    '300': '#84d3ff',
                    '400': '#4ab9ff',
                    '500': '#2097ff',
                    '600': '#0877ff',
                    '700': '#025ff3',
                    '800': '#094cc4',
                    '900': '#0e439a',
                    '950': '#0e2a5d',
                },

                "pg-primary": colors.gray, 
            },

            fontFamily: {
                sans: ['Inter','Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('preline/plugin'),
        forms,
    ],
};
