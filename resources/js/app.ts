import '../styles/sass/app.scss';
import '@/utility';

import type { App } from 'vue';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { registerPlugins } from '@/plugins';
import { registerComponents, resolveComponent } from '@/components';

void createInertiaApp({
    title(title) {
        const appName: string = import.meta.env.VITE_APP_TITLE || 'Apiato';
        return title ? `${title} - ${appName}` : appName;
    },
    resolve: resolveComponent,
    setup({ el, App, props, plugin }) {
        const app: App = createApp({ render: () => h(App, props) });
        app.use(plugin);
        registerPlugins(app);
        registerComponents(app);
        app.mount(el);
    },
});