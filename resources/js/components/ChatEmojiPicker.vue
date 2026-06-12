<script setup lang="ts">
import { Smile } from '@lucide/vue';
import ptBR from 'emoji-picker-element/i18n/pt_BR';
import Picker from 'emoji-picker-element/picker';
import type { EmojiClickEvent } from 'emoji-picker-element/shared';
import Button from 'primevue/button';
import Popover from 'primevue/popover';
import { nextTick, onBeforeUnmount, ref } from 'vue';

defineProps<{
    disabled?: boolean;
}>();

const emit = defineEmits<{
    select: [emoji: string];
}>();

const pickerHost = ref<HTMLElement | null>(null);
const popover = ref<{
    hide: () => void;
    toggle: (event: Event) => void;
} | null>(null);
let picker: Picker | null = null;

const escolherEmoji = (event: EmojiClickEvent) => {
    if (!event.detail.unicode) {
        return;
    }

    emit('select', event.detail.unicode);
    popover.value?.hide();
};

const montarSeletor = async () => {
    await nextTick();

    if (!picker) {
        picker = new Picker({
            i18n: ptBR,
            locale: 'pt',
        });
        picker.style.width = 'min(22rem, calc(100vw - 3rem))';
        picker.style.height = '24rem';
        picker.style.setProperty('--border-radius', '0.75rem');
        picker.style.setProperty('--emoji-size', '1.5rem');
        picker.addEventListener('emoji-click', escolherEmoji);
    }

    if (pickerHost.value && picker.parentElement !== pickerHost.value) {
        pickerHost.value.appendChild(picker);
    }
};

const abrirSeletor = async (event: Event) => {
    popover.value?.toggle(event);
    await montarSeletor();
};

onBeforeUnmount(() => {
    picker?.removeEventListener('emoji-click', escolherEmoji);
    picker?.remove();
});
</script>

<template>
    <Button
        type="button"
        rounded
        outlined
        severity="secondary"
        :disabled="disabled"
        aria-label="Inserir emoji"
        title="Inserir emoji"
        @click="abrirSeletor"
    >
        <template #icon><Smile class="size-5" /></template>
    </Button>

    <Popover ref="popover">
        <div ref="pickerHost" />
    </Popover>
</template>
