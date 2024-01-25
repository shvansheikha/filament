import { createApp, h } from 'vue'
import { createInertiaApp , Link, Head} from '@inertiajs/vue3'
import {InertiaProgress} from '@inertiajs/progress'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import Layout from "./Shared/Layout.vue";
import VueClickAway from "vue3-click-away";
import base from './base';

createInertiaApp({
    resolve: (name) => {
        let page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        page.then((module) => {
            if (page.layout === undefined) {
                module.default.layout ??= Layout;
            }
        });

        return page;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueClickAway)
            .component('Link', Link)
            .component('Head', Head)
            .mixin(base)
            .mount(el)
    },
})

InertiaProgress.init({
    delay: 250,
    color: '#3b82f6',
    includeCSS: true,
    showSpinner: false,
})
