import { useToast } from '@/components/ui/toast/use-toast';

export const { toast } = useToast();

export function showSuccessMessage(title: string, description?: string) {
    toast({ title, description, variant: 'default', duration: 3000 });
}

export function showErrorMessage(title: string, description?: string) {
    toast({ title, description, variant: 'destructive', duration: 3000 });
}
