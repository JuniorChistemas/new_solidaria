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
                        <FormField v-slot="{ componentField }" name="codigo">
                            <FormItem>
                                <FormLabel>Código</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Código" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="fechaEmision">
                            <FormItem>
                                <FormLabel>Fecha de Emisión</FormLabel>
                                <FormControl>
                                    <Input type="date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <FormField v-slot="{ componentField }" name="fechaCredito">
                            <FormItem>
                                <FormLabel>Fecha de Crédito</FormLabel>
                                <FormControl>
                                    <Input type="date" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="idProveedor">
                            <FormItem>
                                <FormLabel>Proveedor</FormLabel>
                                <FormControl>
                                    <SupplierCombobox @select="onSelectProveedor" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="idUser">
                            <FormItem>
                                <FormLabel>Usuario</FormLabel>
                                <FormControl>
                                    <UserCombobox @select="onSelectUser" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="idTipoMovimiento">
                            <FormItem>
                                <FormLabel>Tipo de Movimiento</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger class="w-full">
                                            <SelectValue placeholder="Seleccione el estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Tipo</SelectLabel>
                                                <SelectItem value="1">Factura</SelectItem>
                                                <SelectItem value="2">Guia</SelectItem>
                                                <SelectItem value="3">Boleta</SelectItem>
                                                <SelectItem value="4">Venta</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        
                        <FormField v-slot="{ componentField }" name="estado">
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
                        
                        <FormField v-slot="{ componentField }" name="estadoIgv">
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
                        
                        <FormField v-slot="{ componentField }" name="tipoPago">
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
import SupplierCombobox from '@/components/inputs/SupplierCombobox.vue';
import UserCombobox from '@/components/inputs/UserCombobox.vue';
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
const selectedProveedor = ref<number | null>(null);
const selectedUser = ref<number | null>(null);

// Form validation
const formSchema = toTypedSchema(
    z.object({
        codigo: z.string({ message: 'Campo obligatorio' })
            .min(2, { message: 'Código debe tener al menos 2 caracteres' })
            .max(40, { message: 'Código debe tener máximo 40 caracteres' }),
        fechaEmision: z.string({ message: 'Campo obligatorio' }),
        fechaCredito: z.string().optional(),
        idProveedor: z.number({ message: 'Seleccione un proveedor' }),
        idUser: z.number({ message: 'Seleccione un usuario' }),
        idTipoMovimiento: z.string().or(z.number()).transform(val => Number(val)),
        estado: z.string().or(z.number()).transform(val => Number(val)),
        estadoIgv: z.string().or(z.number()).transform(val => Number(val)),
        tipoPago: z.string({ message: 'Campo obligatorio' }),
    }),
);

// Form
const { handleSubmit, setFieldValue } = useForm({
    validationSchema: formSchema,
    initialValues: {
        idProveedor: null,
        idUser: null,
    }
});

// Función para manejar la selección de proveedor desde el combobox
const onSelectProveedor = (id: number) => {
    selectedProveedor.value = id;
    setFieldValue('idProveedor', id);
};

// Función para manejar la selección de usuario desde el combobox
const onSelectUser = (id: number) => {
    selectedUser.value = id;
    setFieldValue('idUser', id);
};

// Form submit
const onSubmit = handleSubmit((values) => {
    createMovement(values);
});
</script>

<style scoped></style>