import { useConfirm } from 'primevue/useconfirm';

type DestructiveConfirmation = {
    header: string;
    message: string;
    acceptLabel: string;
    accept: () => void;
};

export function useAppConfirm() {
    const confirm = useConfirm();

    const confirmDestructive = ({
        header,
        message,
        acceptLabel,
        accept,
    }: DestructiveConfirmation) => {
        confirm.require({
            group: 'app',
            header,
            message,
            acceptLabel,
            rejectLabel: 'Cancelar',
            defaultFocus: 'reject',
            accept,
            acceptProps: {
                severity: 'danger',
            },
            rejectProps: {
                severity: 'secondary',
                outlined: true,
            },
        });
    };

    return { confirmDestructive };
}
