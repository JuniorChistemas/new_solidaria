<template>
    <Dialog :open="modal" @update:open="clouseModal">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Editando el rol</DialogTitle>
                <DialogDescription>Los datos están validados, llenar con precaución.</DialogDescription>
            </DialogHeader>
            <form @submit="onSubmit" class="flex flex-col gap-4 py-4">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem>
                        <FormLabel>Nombre</FormLabel>
                        <FormControl>
                            <Input id="name" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <DialogFooter>
                    <Button type="submit">Guardar cambios</Button>
                    <Button type="button" variant="outline" @click="clouseModal">Cancelar</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';
import { RoleResource, RoleUpdateRequest } from '../interface/Role';

const props = defineProps<{ modal: boolean; roleData: RoleResource }>();
const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-role', role: RoleUpdateRequest, id_role: number): void;
}>();

const clouseModal = () => emit('emit-close', false);

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2, 'El Nombre debe tener al menos 5 caracteres').max(50, 'Máximo 50 caracteres'),
    }),
);

// Inicialización del formulario
const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.roleData.name,
    },
});
watch(
    () => props.roleData,
    (newData) => {
        if (newData) {
            setValues({
                name: newData.name,
            });
        }
    },
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-role', values, props.roleData.id);
    clouseModal();
});
</script>