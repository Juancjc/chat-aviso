<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { useEcho } from '@laravel/echo-vue';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import { computed, onBeforeUnmount, onMounted } from 'vue';
import type { RealtimeMessage } from '@/types/realtime';

const page = usePage();
const toast = useToast();
const currentUser = computed(() => page.props.auth.user);
let originalTitle = '';
let titleFlashTimer: number | null = null;
let showUnreadTitle = false;

const openedGroupId = computed(() => {
    const match = page.url.match(/^\/grupos\/(\d+)\/chat/);

    return match ? Number(match[1]) : null;
});

const summarize = (message: string) =>
    message.length > 180 ? `${message.slice(0, 177)}...` : message;

const stopTitleFlash = () => {
    if (titleFlashTimer === null) {
        return;
    }

    window.clearInterval(titleFlashTimer);
    titleFlashTimer = null;
    document.title = originalTitle;
};

const startTitleFlash = () => {
    if (
        titleFlashTimer !== null ||
        (document.visibilityState === 'visible' && document.hasFocus())
    ) {
        return;
    }

    originalTitle = document.title;
    showUnreadTitle = true;
    document.title = 'Nova mensagem!';

    titleFlashTimer = window.setInterval(() => {
        showUnreadTitle = !showUnreadTitle;
        document.title = showUnreadTitle ? 'Nova mensagem!' : originalTitle;
    }, 1000);
};

const handlePageReturn = () => {
    if (document.visibilityState === 'visible') {
        stopTitleFlash();
    }
};

const handleMessage = (message: RealtimeMessage) => {
    if (message.user.id === currentUser.value.id) {
        return;
    }

    startTitleFlash();

    if (openedGroupId.value === message.grupo.id) {
        window.dispatchEvent(
            new CustomEvent<RealtimeMessage>('chat:message', {
                detail: message,
            }),
        );
        window.dispatchEvent(
            new CustomEvent<number>('notifications:read-group', {
                detail: message.grupo.id,
            }),
        );

        return;
    }

    window.dispatchEvent(new Event('notifications:refresh'));

    toast.add({
        group: 'realtime-messages',
        severity: 'info',
        summary: message.grupo.nome,
        detail: message,
        life: 8000,
    });
};

const openGroup = (groupId: number) => {
    toast.removeGroup('realtime-messages');
    router.visit(`/grupos/${groupId}/chat`);
};

useEcho<RealtimeMessage>(
    `users.${currentUser.value.id}`,
    '.mensagem.enviada',
    handleMessage,
);

onMounted(() => {
    document.addEventListener('visibilitychange', handlePageReturn);
    window.addEventListener('focus', stopTitleFlash);
});

onBeforeUnmount(() => {
    document.removeEventListener('visibilitychange', handlePageReturn);
    window.removeEventListener('focus', stopTitleFlash);
    stopTitleFlash();
});
</script>

<template>
    <Toast position="top-center" group="realtime-messages">
        <template #message="slotProps">
            <div class="flex min-w-0 flex-1 flex-col items-start gap-3">
                <div class="flex min-w-0 items-center gap-2">
                    <Avatar
                        :label="
                            slotProps.message.detail.user.avatar_emoji || '🙂'
                        "
                        shape="circle"
                        class="shrink-0 bg-primary/10 text-lg"
                    />
                    <div class="min-w-0">
                        <div class="truncate font-bold">
                            {{ slotProps.message.detail.user.name }}
                        </div>
                        <div class="truncate text-sm text-muted-foreground">
                            {{ slotProps.message.detail.grupo.nome }}
                        </div>
                    </div>
                </div>

                <p class="max-w-sm text-sm break-words whitespace-pre-wrap">
                    {{ summarize(slotProps.message.detail.mensagem) }}
                </p>

                <Button
                    size="small"
                    label="Abrir grupo"
                    @click="openGroup(slotProps.message.detail.grupo.id)"
                />
            </div>
        </template>
    </Toast>
</template>
