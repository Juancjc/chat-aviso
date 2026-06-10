import { router } from '@inertiajs/vue3';
import type { ToastServiceMethods } from 'primevue/toastservice';
import type { FlashToast } from '@/types/ui';

const summaries: Record<FlashToast['type'], string> = {
    success: 'Sucesso',
    info: 'Informação',
    warning: 'Atenção',
    error: 'Não foi possível concluir',
};

const severity = (
    type: FlashToast['type'],
): 'success' | 'info' | 'warn' | 'error' =>
    type === 'warning' ? 'warn' : type;

const show = (toast: ToastServiceMethods, data: FlashToast) => {
    toast.add({
        group: 'app',
        severity: severity(data.type),
        summary: summaries[data.type],
        detail: data.message,
        life: data.type === 'error' ? 6000 : 4500,
    });
};

export function initializeFlashToast(toast: ToastServiceMethods): void {
    router.on('flash', (event) => {
        const flash = (event as CustomEvent).detail?.flash;
        const data = flash?.toast as FlashToast | undefined;

        if (!data) {
            return;
        }

        show(toast, data);
    });

    router.on('error', (event) => {
        const errors = event.detail.errors;
        const message = Object.values(errors)[0];

        if (message) {
            show(toast, { type: 'error', message });
        }
    });

    router.on('networkError', () => {
        show(toast, {
            type: 'error',
            message: 'Falha de conexão. Verifique sua rede e tente novamente.',
        });
    });

    router.on('httpException', () => {
        show(toast, {
            type: 'error',
            message: 'O servidor não conseguiu concluir a solicitação.',
        });
    });
}
