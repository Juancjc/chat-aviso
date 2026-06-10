import { createInertiaApp } from '@inertiajs/vue3';
import { configureEcho } from '@laravel/echo-vue';
import Aura from '@primeuix/themes/aura';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

if (typeof window !== 'undefined') {
    const websocketIsSecure = window.location.protocol === 'https:';
    const websocketPort = Number(
        window.location.port || (websocketIsSecure ? 443 : 80),
    );

    configureEcho({
        broadcaster: 'reverb',
        wsHost: window.location.hostname,
        wsPort: websocketPort,
        wssPort: websocketPort,
        forceTLS: websocketIsSecure,
        enabledTransports: ['ws', 'wss'],
    });
}

const configuredAppName = import.meta.env.VITE_APP_NAME;
const appName =
    configuredAppName && configuredAppName !== 'Laravel'
        ? configuredAppName
        : 'Sinaliza';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name === 'grupos/Convite':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    progress: {
        color: '#2563EB',
    },
    withApp: (app) => {
        app.use(PrimeVue, {
            theme: {
                preset: Aura,
            },
        });
        app.use(ToastService);
        app.directive('tooltip', Tooltip);

        if (typeof window !== 'undefined') {
            initializeFlashToast(app.config.globalProperties.$toast);
        }
    },
});

if (typeof window !== 'undefined') {
    // This will set light / dark mode on page load...
    initializeTheme();
}
