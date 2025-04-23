<template>
    <Head title="Nuevo Movimiento"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO MOVIMIENTO</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo movimiento</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">
                        <FormField v-slot="{ componentField }" name="code">
                            <FormItem>
                                <FormLabel>Código</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Código" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="issue_date">
                            <FormItem>
                                <FormLabel>Fecha de Emisión</FormLabel>
                                <FormControl>
                                    <Input type="date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="credit_date">
                            <FormItem>
                                <FormLabel>Fecha de Crédito</FormLabel>
                                <FormControl>
                                    <Input type="date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="supplier_id">
                            <FormItem>
                                <FormLabel>Proveedor</FormLabel>
                                <FormControl>
                                    <SupplierCombobox @select="onSelectSupplier" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="user_id">
                            <FormItem>
                                <FormLabel>Usuario</FormLabel>
                                <FormControl>
                                    <UserCombobox @select="onSelectUser" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="type_movement_id">
                            <FormItem>
                                <FormLabel>Tipo de Movimiento</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Seleccione el tipo de movimiento" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Tipo</SelectLabel>
                                                <SelectItem value="1">Factura</SelectItem>
                                                <SelectItem value="2">Guía</SelectItem>
                                                <SelectItem value="3">Boleta</SelectItem>
                                                <SelectItem value="4">Venta</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="status">
                            <FormItem>
                                <FormLabel>Estado</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Seleccione el estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Estado</SelectLabel>
                                                <SelectItem value="2">Anulado</SelectItem>
                                                <SelectItem value="1">Activo</SelectItem>
                                                <SelectItem value="0">Eliminado</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="igv_status">
                            <FormItem>
                                <FormLabel>Estado IGV</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Seleccione el estado de IGV" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Estado IGV</SelectLabel>
                                                <SelectItem value="2">No Incluye</SelectItem>
                                                <SelectItem value="1">Incluye</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="payment_type">
                            <FormItem>
                                <FormLabel>Tipo de Pago</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Seleccione el tipo de pago" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Tipo de Pago</SelectLabel>
                                                <SelectItem value="contado">Contado</SelectItem>
                                                <SelectItem value="credito">Crédito</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
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
import SupplierCombobox from '@/components/Inputs/SupplierCombobox.vue';
import UserCombobox from '@/components/Inputs/UserCombobox.vue';
import { ref } from 'vue';

// Composable
import { useMovement } from '@/composables/useMovement';
const { createMovement } = useMovement();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Movimientos',
        href: '/panel/movements',
    },
    {
        title: 'Crear movimiento',
        href: '/panel/movements/create',
    },
];

// ID del proveedor y usuario seleccionados
const selectedSupplier = ref<number | null>(null);
const selectedUser = ref<number | null>(null);

// Form validation
const formSchema = toTypedSchema(
    z.object({
        code: z.string({ message: 'Campo obligatorio' })
            .min(2, { message: 'Código debe tener al menos 2 caracteres' })
            .max(15, { message: 'Código debe tener máximo 15 caracteres' }),
        issue_date: z.string({ message: 'Campo obligatorio' }),
        credit_date: z.string().optional(),
        supplier_id: z.number({ message: 'Seleccione un proveedor' }),
        user_id: z.number({ message: 'Seleccione un usuario' }),
        type_movement_id: z.string().or(z.number()).transform(val => Number(val)),
        status: z.string().or(z.number()).transform(val => Number(val)),
        igv_status: z.string().or(z.number()).transform(val => Number(val)),
        payment_type: z.string({ message: 'Campo obligatorio' }),
    }),
);

// Form
const { handleSubmit, setFieldValue } = useForm({
    validationSchema: formSchema,
    initialValues: {
        supplier_id: null,
        user_id: null,
        payment_type: 'contado',
        status: 1,
        igv_status: 1,
        type_movement_id: 1,
    }
});

// Función para manejar la selección de proveedor desde el combobox
const onSelectSupplier = (id: number) => {
    selectedSupplier.value = id;
    setFieldValue('supplier_id', id);
};

// Función para manejar la selección de usuario desde el combobox
const onSelectUser = (id: number) => {
    selectedUser.value = id;
    setFieldValue('user_id', id);
};

// Form submit
const onSubmit = handleSubmit((values) => {
    createMovement(values);
});
</script>

<style scoped></style>