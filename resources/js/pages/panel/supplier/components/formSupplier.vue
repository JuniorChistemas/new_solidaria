<template>
    <Head title="Nuevo Proveedor"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO PROVEEDOR</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo proveedor</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Razón Social</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="nombre" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="ruc">
                            <FormItem>
                                <FormLabel>Ruc</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="10000000000" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="phone">
                            <FormItem>
                                <FormLabel>Phone</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="910343234" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="address">
                            <FormItem>
                                <FormLabel>Dirección</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Calle Los Cocos 145, Urb. Santa María del Pinar" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="state">
                            <FormItem>
                                <FormLabel>Estado</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField" disabled>
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Selecciona el estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Estado</SelectLabel>
                                                <SelectItem value="activo"> Activo </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <div class="container flex justify-end gap-4">
                            <Button type="submit" variant="default"> Enviar </Button>
                            <Button type="reset" variant="outline"> Borrar </Button>
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

//composable
import { useSupplier } from '@/composables/useSupplier';
const { createSupplier } = useSupplier();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Proveedores',
        href: '/panel/suppliers',
    },
    {
        title: 'Exportar',
        href: '/panel/suppliers/export',
    },
    {
        title: 'Crear proveedor',
        href: '/panel/suppliers/create',
    },
];

// Form validation
const formSchema = toTypedSchema(
    z.object({
        name: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'nombre mayor a 5 letras' })
            .max(50, { message: 'nombre menor a 50 letras' }),
        ruc: z
            .string({ message: 'Campo obligatorio' })
            .length(11, { message: 'El RUC debe tener 11 dígitos' })
            .regex(/^\d+$/, { message: 'El RUC solo debe contener números' }),
        phone: z
            .string({ message: 'Campo obligatorio' })
            .length(9, { message: 'El teléfono debe tener 9 dígitos' })
            .regex(/^\d+$/, { message: 'El teléfono solo debe contener números' }),
        address: z
            .string({ message: 'campo obligatorio' })
            .min(2, { message: 'dirección mayor a 5 letras' })
            .max(50, { message:'direccion menor a 50 letras' }),
        state: z.enum(['activo', 'inactivo'], { message: 'estado invalido' }),
    }),
);

// Form submit
const { handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: {         
        state: 'activo',     
    },
});
const onSubmit = handleSubmit((values) => {
    console.log('hola')
    createSupplier(values);
});
</script>
<style scoped></style>