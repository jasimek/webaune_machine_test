import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import { usePassThrough } from "primevue/passthrough";
import ToastService from 'primevue/toastservice';
import Tailwind from "primevue/passthrough/tailwind";
// import { InertiaProgress } from '@inertiajs/progress'

const appName = import.meta.env.VITE_APP_NAME || 'New Project';

const CustomTailwind = usePassThrough(
    Tailwind,
    {
        datatable: {
            tbody: { class: '!bg-white dark:!bg-gray-800 dark:!divide-gray-700 !divide-gray-200 !divide-y' },
            bodyRow: { class: 'hover:!bg-gray-100 dark:hover:!bg-gray-700 !bg-white dark:!bg-gray-800 dark:!divide-gray-700 !divide-gray-200 !divide-y' },
            wrapper:{ style: { 'border': '1px solid #F1E7E7','border-bottom': 'hidden','border-radius': '10px' } },
            paginator: (options) => ({
                // root: { class: '!bg-white' },
            })
        },
        column: {
            bodyCell: { class:'font-jakarta-medium text-[#333333] text-sm', style: { 'border-bottom': '1px solid #F1E7E7 ' } },
            // bodyRow: { class: '!border-b' },
            headerCell: { class: '!p-4 !text-xs !font-medium !text-left !text-gray-500 !uppercase dark:!text-gray-400',
                          style: { 'background-color': '#E1F0FD' }
                        },

            headerTitle:{ class:'font-jakarta-medium text-[#333333] text-base'},
            headerCheckbox:{ 
                // class:'!bg-gray-100',
                style:{
                'width':'1rem',
                'height':'1rem',
                'border-radius': '0.25rem'
                },
            
            },
            checkboxWrapper:{ class:'ml-4' },
            checkbox:{  
                style:{
                'width':'1rem',
                'height':'1rem',
                'border-radius': '0.25rem'
                }, 
            }

        },
    },
    {
        mergeSections: true,
        mergeProps: false
    }
);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(ToastService)
            .use(PrimeVue,{ unstyled: true, pt: CustomTailwind })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// InertiaProgress.init()