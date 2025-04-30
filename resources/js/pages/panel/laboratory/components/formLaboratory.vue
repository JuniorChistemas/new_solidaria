<template>
    <Head title="Nuevo Laboratorio" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO LABORATORIO</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo laboratorio</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">
                        <!-- Campo para ingresar el nombre del laboratorio -->
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Nombre</FormLabel>
                                <FormControl>
                                    <Input
                                        type="text"
                                        placeholder="Nombre del laboratorio"
                                        v-bind="componentField"
                                        @input="componentField.onChange(($event.target.value as string).toUpperCase())"
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <!-- Campo para ingresar el estado del laboratorio -->
                        <FormField v-slot="{ componentField }" name="state">
                    <FormItem>
                        <FormLabel>Estado</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField" disabled>
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona el estado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Estado</SelectLabel>
                                        <SelectItem value="activo">Activo</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                        <!-- BOTONES PARA ENVIAR Y BORRAR -->
                        <div class="container flex justify-end gap-4">
                            <Button type="submit" variant="default">Enviar</Button>
                            <Button type="reset" variant="outline">Borrar</Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectGroup, SelectItem, SelectLabel } from '@/components/ui/select';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

// composable
import { useLaboratory } from '@/composables/useLaboratory';
const { createLaboratory } = useLaboratory();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Laboratorios',
        href: '/panel/laboratories',
    },
    {
        title: 'Exportar',
        href: '/panel/laboratories/export',
    },
    {
        title: 'Crear laboratorio',
        href: '/panel/laboratories/create',
    },
];

// Validación del formulario
const formSchema = toTypedSchema(
    z.object({
        name: z
            .string({ message: 'Campo obligatorio' })
            .min(2, { message: 'El nombre debe tener al menos 2 caracteres' })
            .max(100, { message: 'El nombre no puede superar los 100 caracteres' }),
        state: z.enum(['activo', 'inactivo'], { message: 'Estado inválido' }),
    }),
);

// Envío del formulario
const { handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: {         
        state: 'activo',     
    },
});

const onSubmit = handleSubmit((values) => {
    const laboratoryData = {
        name: values.name,
        state: values.state === 'activo',
    };

    createLaboratory(laboratoryData);
});
</script>

<style scoped></style>
