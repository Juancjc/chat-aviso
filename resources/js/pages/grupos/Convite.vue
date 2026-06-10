<script setup lang="ts">
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Clock, LogIn, MessageCircle } from '@lucide/vue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Message from 'primevue/message';
import { computed } from 'vue';
import AppToast from '@/components/AppToast.vue';

const props = defineProps<{
    convite: {
        token: string;
        expires_at: string;
        valido: boolean;
        grupo: { id: number; nome: string; descricao: string | null };
        admin: { id: number; name: string };
    };
}>();

const page = usePage();
const user = computed(() => page.props.auth.user ?? null);
const isGuest = computed(() => !user.value);
const isAdmin = computed(() => user.value?.tipo_usuario === 'admin');
const form = useForm({});

const aceitar = () => {
    form.post(`/entrar/${props.convite.token}`);
};

const formatarExpiracao = (date: string) =>
    new Intl.DateTimeFormat('pt-BR', {
        dateStyle: 'long',
        timeStyle: 'short',
    }).format(new Date(date));
</script>

<template>
    <Head :title="`Convite - ${convite.grupo.nome}`" />
    <AppToast />

    <header class="border-b border-border bg-background">
        <div
            class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4"
        >
            <button
                class="flex items-center gap-2 font-semibold"
                @click="router.visit('/')"
            >
                <span
                    class="flex size-9 items-center justify-center rounded-xl bg-blue-600 text-white"
                >
                    <MessageCircle class="size-5" />
                </span>
                Chat Aviso
            </button>
            <Button
                v-if="isGuest"
                label="Fazer login"
                severity="secondary"
                outlined
                @click="router.visit('/login')"
            />
            <Button
                v-else
                label="Dashboard"
                severity="secondary"
                outlined
                @click="router.visit('/dashboard')"
            />
        </div>
    </header>

    <main
        class="mx-auto flex min-h-[calc(100vh-4rem)] w-full max-w-2xl items-center p-4 md:p-8"
    >
        <Card class="w-full border border-border shadow-lg">
            <template #title>
                <span class="flex items-center gap-3">
                    <span class="rounded-2xl bg-blue-100 p-3 text-blue-700">
                        <MessageCircle class="size-6" />
                    </span>
                    Convite para entrar no grupo
                </span>
            </template>
            <template #content>
                <div class="mt-6 space-y-6">
                    <div>
                        <h1 class="text-2xl font-semibold">
                            {{ convite.grupo.nome }}
                        </h1>
                        <p class="mt-2 text-muted-foreground">
                            {{
                                convite.grupo.descricao ||
                                'Grupo sem descrição.'
                            }}
                        </p>
                        <p class="mt-3 text-sm text-muted-foreground">
                            Administrado por {{ convite.admin.name }}
                        </p>
                    </div>

                    <Message v-if="!convite.valido" severity="error">
                        Este convite expirou ou foi revogado.
                    </Message>
                    <Message v-else-if="isGuest" severity="info">
                        Faça login como aluno para aceitar este convite.
                    </Message>
                    <Message v-else-if="isAdmin" severity="warn">
                        Contas de administrador não podem entrar em grupos por
                        convite.
                    </Message>
                    <Message v-else severity="info">
                        <span class="flex items-center gap-2">
                            <Clock class="size-4" />
                            Válido até
                            {{ formatarExpiracao(convite.expires_at) }}.
                        </span>
                    </Message>

                    <div class="flex flex-wrap justify-end gap-3">
                        <Button
                            label="Voltar ao dashboard"
                            severity="secondary"
                            outlined
                            @click="router.visit('/dashboard')"
                        >
                            <template #icon
                                ><ArrowLeft class="size-4"
                            /></template>
                        </Button>
                        <Button
                            :label="
                                isGuest
                                    ? 'Fazer login para entrar'
                                    : 'Entrar no grupo'
                            "
                            :disabled="!convite.valido || isAdmin"
                            :loading="form.processing"
                            @click="
                                isGuest ? router.visit('/login') : aceitar()
                            "
                        >
                            <template #icon><LogIn class="size-4" /></template>
                        </Button>
                    </div>
                </div>
            </template>
        </Card>
    </main>
</template>
