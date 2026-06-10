<script setup lang="ts">
import { AlertTriangle } from '@lucide/vue';
import ConfirmDialog from 'primevue/confirmdialog';
</script>

<template>
    <ConfirmDialog
        group="app"
        :draggable="false"
        :breakpoints="{ '640px': 'calc(100vw - 2rem)' }"
        class="max-w-md"
    >
        <template #icon>
            <span
                class="mr-4 flex size-12 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600 dark:bg-red-950 dark:text-red-300"
            >
                <AlertTriangle class="size-6" />
            </span>
        </template>
    </ConfirmDialog>
</template>
