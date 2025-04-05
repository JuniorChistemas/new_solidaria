<template>
    <Dialog :open="modal" @update:open="closeModal">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Editando el doctor</DialogTitle>
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
                <FormField v-slot="{ componentField }" name="code">
                    <FormItem>
                        <FormLabel>Código</FormLabel>
                        <FormControl>
                            <Input id="code" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="status">
                    <FormItem>
                        <FormLabel>Estado</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona el estado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Estado</SelectLabel>
                                        <SelectItem value="activo">Activo</SelectItem>
                                        <SelectItem value="inactivo">Inactivo</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="start_date">
                    <FormItem>
                        <FormLabel>Fecha de inicio</FormLabel>
                        <FormControl>
                            <Input id="start_date" type="datetime-local" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <DialogFooter>
                    <Button type="submit">Guardar cambios</Button>
                    <Button type="button" variant="outline" @click="closeModal">Cancelar</Button>
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
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import { z } from 'zod';
import { DoctorResource, updateDoctorRequest } from '../interface/Doctor';

const props = defineProps<{
    modal: boolean;
    doctorData: DoctorResource;
}>();

const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-doctor', doctor: updateDoctorRequest, id_doctor: number): void;
}>();

const closeModal = () => {
    emit('emit-close', false);
    console.log('close modal');
};

const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2, 'El nombre debe tener al menos 2 caracteres').max(150, 'Máximo 150 caracteres'),
        code: z.string().min(2, 'El código debe tener al menos 2 caracteres').max(6, 'Máximo 6 caracteres'),
        status: z.enum(['activo', 'inactivo']),
        start_date: z.string().refine((date) => !isNaN(Date.parse(date)), { message: 'Fecha inválida' }),
    }),
);

const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.doctorData.name,
        code: props.doctorData.code,
        status: props.doctorData.state ? 'activo' : 'inactivo',
        start_date: props.doctorData.start_date,
    },
});

watch(
    () => props.doctorData,
    (newData) => {
        if (newData) {
            setValues({
                name: newData.name,
                code: newData.code,
                status: newData.state ? 'activo' : 'inactivo',
                start_date: newData.start_date,
            });
        }
    },
);

const onSubmit = handleSubmit((values) => {
    const doctor: updateDoctorRequest = {
        name: values.name,
        code: values.code,
        state: values.status === 'activo',
        start_date: values.start_date,
    };
    emit('update-doctor', doctor, props.doctorData.id);
    closeModal();
});
</script>
<style scoped></style>
