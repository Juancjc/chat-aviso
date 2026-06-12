import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import type { UnreadNotification } from '@/types/notifications';

const unreadNotifications = ref<UnreadNotification[]>([]);

export function useUnreadNotifications() {
    const page = usePage();

    watch(
        () => page.props.unreadNotifications,
        (notifications) => {
            unreadNotifications.value = [...notifications];
        },
        { immediate: true },
    );

    const unreadCountByGroup = computed(() =>
        unreadNotifications.value.reduce<Record<number, number>>(
            (counts, notification) => {
                const groupId = notification.group.id;
                counts[groupId] = (counts[groupId] ?? 0) + 1;

                return counts;
            },
            {},
        ),
    );

    return {
        unreadNotifications,
        unreadCountByGroup,
    };
}
