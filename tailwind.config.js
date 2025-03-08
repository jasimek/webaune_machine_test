import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/primevue/**/*.{vue,js,ts,jsx,tsx}',
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        "./node_modules/flowbite/**/*.{js,jsx,ts,tsx}"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                
                'jakarta-normal': ['Plus Jakarta Sans',{ 
                    fontVariationSettings: '"wght" 400'
                }],
                'jakarta-medium': ['Plus Jakarta Sans',{ 
                    fontVariationSettings: '"wght" 500'
                }],
                'jakarta-semibold': ['Plus Jakarta Sans',{ 
                    fontVariationSettings: '"wght" 600'
                }],
                'jakarta-bold': ['Plus Jakarta Sans',{ 
                    fontVariationSettings: '"wght" 700'
                }],
                'urbanist-normal': ['Urbanist',{ 
                    fontVariationSettings: '"wght" 400'
                }],
                'urbanist-medium': ['Urbanist',{ 
                    fontVariationSettings: '"wght" 500'
                }],
                'urbanist-semibold': ['Urbanist',{ 
                    fontVariationSettings: '"wght" 600'
                }],
                'urbanist-bold': ['Urbanist',{ 
                    fontVariationSettings: '"wght" 700'
                }]
            },
        },
    },

    plugins: [
        require('flowbite/plugin'),
        forms
    ],
};
