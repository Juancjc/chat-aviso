<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import {
    ArrowRight,
    BellRing,
    CheckCircle2,
    Clock3,
    Mail,
    MessageCircle,
    Radio,
    ShieldCheck,
    Sparkles,
    UserRoundPlus,
    UsersRound,
} from '@lucide/vue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Tag from 'primevue/tag';
import { computed } from 'vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import AppToast from '@/components/AppToast.vue';
import { dashboard, login, register } from '@/routes';

const page = usePage();
const isAuthenticated = computed(() => Boolean(page.props.auth.user));

const primaryAction = () => {
    router.visit(isAuthenticated.value ? dashboard().url : register().url);
};

const features = [
    {
        title: 'Grupos organizados',
        description:
            'Separe turmas, equipes ou projetos e mantenha participantes e conversas no lugar certo.',
        icon: UsersRound,
        tone: 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300',
    },
    {
        title: 'Chat em tempo real',
        description:
            'Mensagens chegam na hora para aproximar administradores e participantes.',
        icon: MessageCircle,
        tone: 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300',
    },
    {
        title: 'Avisos importantes',
        description:
            'Envie comunicados para todo o grupo com notificações dentro da plataforma.',
        icon: BellRing,
        tone: 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
    },
    {
        title: 'Convites temporários',
        description:
            'Compartilhe acessos com prazo definido e mantenha o controle de quem entra.',
        icon: Clock3,
        tone: 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300',
    },
];

const steps = [
    {
        number: '01',
        title: 'Crie um grupo',
        description: 'Dê um nome, descreva o objetivo e reúna sua comunidade.',
    },
    {
        number: '02',
        title: 'Convide participantes',
        description:
            'Adicione alunos diretamente ou compartilhe um link temporário.',
    },
    {
        number: '03',
        title: 'Converse e sinalize',
        description:
            'Use o chat no dia a dia e os avisos para o que não pode passar despercebido.',
    },
];
</script>

<template>
    <Head title="Comunicação simples para grupos" />

    <div class="min-h-screen overflow-hidden bg-background text-foreground">
        <AppToast />

        <header
            class="sticky top-0 z-40 border-b border-border/70 bg-background/90 backdrop-blur-xl"
        >
            <div
                class="mx-auto flex h-18 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <button
                    type="button"
                    class="flex items-center gap-3 text-left"
                    @click="router.visit('/')"
                >
                    <AppLogoIcon class="size-11 rounded-2xl shadow-sm" />
                    <span class="leading-tight">
                        <strong class="block text-lg font-bold"
                            >Sinaliza</strong
                        >
                        <span class="block text-xs text-muted-foreground">
                            Chat e avisos
                        </span>
                    </span>
                </button>

                <div class="flex items-center gap-2">
                    <Button
                        v-if="!isAuthenticated"
                        label="Entrar"
                        severity="secondary"
                        text
                        @click="router.visit(login().url)"
                    />
                    <Button
                        :label="
                            isAuthenticated ? 'Abrir painel' : 'Criar conta'
                        "
                        size="small"
                        @click="primaryAction"
                    >
                        <template #icon>
                            <ArrowRight class="size-4" />
                        </template>
                    </Button>
                </div>
            </div>
        </header>

        <main>
            <section class="relative">
                <div
                    class="absolute inset-x-0 top-0 -z-0 h-[34rem] bg-[radial-gradient(circle_at_top_left,rgba(37,99,235,0.18),transparent_38%),radial-gradient(circle_at_top_right,rgba(6,182,212,0.18),transparent_38%)]"
                />
                <div
                    class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[1.02fr_0.98fr] lg:px-8 lg:py-28"
                >
                    <div>
                        <Tag
                            value="Comunicação que chega"
                            severity="info"
                            rounded
                            class="mb-6"
                        >
                            <template #icon>
                                <Radio class="mr-1.5 size-3.5" />
                            </template>
                        </Tag>

                        <h1
                            class="max-w-3xl text-4xl font-black tracking-[-0.045em] text-balance sm:text-5xl lg:text-7xl"
                        >
                            Avisos que chegam.
                            <span
                                class="bg-gradient-to-r from-blue-700 to-cyan-500 bg-clip-text text-transparent"
                            >
                                Conversas que organizam.
                            </span>
                        </h1>
                        <p
                            class="mt-6 max-w-2xl text-lg leading-8 text-muted-foreground sm:text-xl"
                        >
                            O Sinaliza reúne grupos, chat, avisos e notificações
                            em tempo real para sua escola, curso, equipe ou
                            comunidade.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <Button
                                :label="
                                    isAuthenticated
                                        ? 'Ir para o dashboard'
                                        : 'Começar agora'
                                "
                                size="large"
                                raised
                                @click="primaryAction"
                            >
                                <template #icon>
                                    <ArrowRight class="size-5" />
                                </template>
                            </Button>
                            <Button
                                v-if="!isAuthenticated"
                                label="Já tenho uma conta"
                                severity="secondary"
                                size="large"
                                outlined
                                @click="router.visit(login().url)"
                            />
                        </div>

                        <div
                            class="mt-9 flex flex-wrap gap-x-6 gap-y-3 text-sm text-muted-foreground"
                        >
                            <span class="flex items-center gap-2">
                                <CheckCircle2 class="size-4 text-emerald-500" />
                                Atualizações em tempo real
                            </span>
                            <span class="flex items-center gap-2">
                                <CheckCircle2 class="size-4 text-emerald-500" />
                                Experiência simples no celular
                            </span>
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-xl">
                        <div
                            class="absolute -inset-4 -z-10 rounded-[2.5rem] bg-gradient-to-br from-blue-600/25 to-cyan-400/20 blur-2xl"
                        />
                        <div
                            class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 p-4 shadow-2xl shadow-blue-950/15 backdrop-blur dark:border-white/10 dark:bg-neutral-950/90"
                        >
                            <div
                                class="mb-4 flex items-center justify-between rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 px-4 py-3 text-white"
                            >
                                <div class="flex items-center gap-3">
                                    <AppLogoIcon
                                        class="size-10 rounded-xl bg-white shadow-sm"
                                    />
                                    <div>
                                        <p class="text-sm font-bold">
                                            Sinaliza
                                        </p>
                                        <p class="text-xs text-blue-100">
                                            Tudo certo por aqui
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold"
                                >
                                    online
                                </span>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-[0.9fr_1.1fr]">
                                <div class="space-y-3">
                                    <div
                                        class="rounded-2xl border border-border bg-muted/40 p-4"
                                    >
                                        <p
                                            class="mb-3 text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                                        >
                                            Seus grupos
                                        </p>
                                        <div class="space-y-2.5">
                                            <div
                                                class="rounded-xl bg-blue-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm"
                                            >
                                                Turma de Tecnologia
                                            </div>
                                            <div
                                                class="rounded-xl bg-background px-3 py-2.5 text-sm"
                                            >
                                                Coordenação
                                            </div>
                                            <div
                                                class="rounded-xl bg-background px-3 py-2.5 text-sm"
                                            >
                                                Projeto Integrador
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-3 text-amber-950 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-100"
                                    >
                                        <BellRing class="size-5 shrink-0" />
                                        <div>
                                            <p class="text-xs font-bold">
                                                Novo aviso
                                            </p>
                                            <p class="text-xs opacity-75">
                                                Reunião amanhã às 14h.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="flex min-h-72 flex-col rounded-2xl border border-border bg-background p-4"
                                >
                                    <div
                                        class="flex items-center gap-3 border-b border-border pb-3"
                                    >
                                        <div
                                            class="flex size-9 items-center justify-center rounded-full bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300"
                                        >
                                            <UsersRound class="size-4" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">
                                                Turma de Tecnologia
                                            </p>
                                            <p
                                                class="text-xs text-muted-foreground"
                                            >
                                                28 participantes
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-1 flex-col justify-end gap-3 py-4 text-xs"
                                    >
                                        <div
                                            class="max-w-[88%] rounded-2xl rounded-bl-sm bg-muted px-3 py-2"
                                        >
                                            O material já está disponível no
                                            grupo.
                                        </div>
                                        <div
                                            class="ml-auto max-w-[88%] rounded-2xl rounded-br-sm bg-blue-600 px-3 py-2 text-white"
                                        >
                                            Perfeito, obrigado pelo aviso!
                                        </div>
                                        <div
                                            class="max-w-[88%] rounded-2xl rounded-bl-sm bg-muted px-3 py-2"
                                        >
                                            Qualquer dúvida, mandem por aqui.
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center justify-between rounded-xl border border-border bg-muted/40 px-3 py-2 text-xs text-muted-foreground"
                                    >
                                        Escreva uma mensagem
                                        <MessageCircle class="size-4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-y border-border bg-muted/30">
                <div
                    class="mx-auto max-w-7xl px-4 py-18 sm:px-6 lg:px-8 lg:py-24"
                >
                    <div class="mx-auto max-w-2xl text-center">
                        <Tag value="Tudo em um só lugar" severity="secondary" />
                        <h2
                            class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl"
                        >
                            Menos ruído, mais gente informada
                        </h2>
                        <p class="mt-4 text-muted-foreground">
                            Recursos pensados para tornar a comunicação diária
                            mais clara, rápida e fácil de acompanhar.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                        <Card
                            v-for="feature in features"
                            :key="feature.title"
                            class="border border-border shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg"
                        >
                            <template #content>
                                <div
                                    :class="feature.tone"
                                    class="mb-5 flex size-12 items-center justify-center rounded-2xl"
                                >
                                    <component
                                        :is="feature.icon"
                                        class="size-6"
                                    />
                                </div>
                                <h3 class="text-lg font-bold">
                                    {{ feature.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-muted-foreground"
                                >
                                    {{ feature.description }}
                                </p>
                            </template>
                        </Card>
                    </div>
                </div>
            </section>

            <section
                class="mx-auto grid max-w-7xl gap-14 px-4 py-18 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8 lg:py-24"
            >
                <div>
                    <Tag value="Simples de começar" severity="success">
                        <template #icon>
                            <Sparkles class="mr-1.5 size-3.5" />
                        </template>
                    </Tag>
                    <h2
                        class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl"
                    >
                        Da criação do grupo ao primeiro aviso em poucos passos
                    </h2>
                    <p class="mt-4 max-w-xl text-muted-foreground">
                        O fluxo foi feito para ser direto tanto para quem
                        organiza quanto para quem participa.
                    </p>

                    <div
                        class="mt-8 rounded-3xl border border-blue-200 bg-blue-50 p-6 dark:border-blue-900 dark:bg-blue-950/50"
                    >
                        <div class="flex items-start gap-4">
                            <ShieldCheck
                                class="mt-1 size-7 shrink-0 text-blue-700 dark:text-blue-300"
                            />
                            <div>
                                <h3 class="font-bold">
                                    Controle para administradores
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-muted-foreground"
                                >
                                    Gerencie grupos, participantes, convites,
                                    comunicados e conversas sem complicação.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <Card
                        v-for="step in steps"
                        :key="step.number"
                        class="border border-border shadow-sm"
                    >
                        <template #content>
                            <div class="flex gap-5">
                                <span
                                    class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-neutral-950 font-black text-white dark:bg-white dark:text-neutral-950"
                                >
                                    {{ step.number }}
                                </span>
                                <div>
                                    <h3 class="text-lg font-bold">
                                        {{ step.title }}
                                    </h3>
                                    <p
                                        class="mt-1 text-sm leading-6 text-muted-foreground"
                                    >
                                        {{ step.description }}
                                    </p>
                                </div>
                            </div>
                        </template>
                    </Card>
                </div>
            </section>

            <section
                class="mx-auto max-w-7xl px-4 pb-18 sm:px-6 lg:px-8 lg:pb-24"
            >
                <div
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 px-6 py-12 text-white shadow-2xl shadow-blue-950/20 sm:px-10 lg:px-16 lg:py-16"
                >
                    <div
                        class="absolute -top-20 -right-20 size-72 rounded-full border-[3rem] border-white/10"
                    />
                    <div
                        class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between"
                    >
                        <div class="max-w-2xl">
                            <div class="mb-4 flex items-center gap-3">
                                <AppLogoIcon
                                    class="size-12 rounded-2xl bg-white shadow-lg"
                                />
                                <span class="font-bold">Sinaliza</span>
                            </div>
                            <h2
                                class="text-3xl font-black tracking-tight sm:text-4xl"
                            >
                                Sua comunidade merece uma comunicação mais
                                clara.
                            </h2>
                            <p class="mt-4 text-blue-100">
                                Crie sua conta, organize seus grupos e deixe os
                                avisos importantes realmente visíveis.
                            </p>
                        </div>
                        <Button
                            :label="
                                isAuthenticated
                                    ? 'Abrir dashboard'
                                    : 'Criar minha conta'
                            "
                            severity="contrast"
                            size="large"
                            @click="primaryAction"
                        >
                            <template #icon>
                                <UserRoundPlus class="size-5" />
                            </template>
                        </Button>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-border">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 text-sm text-muted-foreground sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8"
            >
                <div class="flex items-center gap-2">
                    <AppLogoIcon class="size-7 rounded-lg" />
                    <span>Sinaliza · Chat e avisos para grupos</span>
                </div>
                <span class="flex items-center gap-2">
                    <Mail class="size-4" />
                    Informação no lugar certo, na hora certa.
                </span>
            </div>
        </footer>
    </div>
</template>
