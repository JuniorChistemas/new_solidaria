<template>
    <Head title="Nueva "></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO ROL</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo rol</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Nombre</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Nombre" v-bind="componentField" />
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
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

//composable
import { useRole } from '@/composables/useRole';
const { createRole } = useRole();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/panel/roles',
    },
    /*{
        title: 'Exportar a Excel',
        href: '/panel/reports/export-excel-roles',
        download: true,
    },
    {
        title: 'Exportar a PDF',
        href: '/panel/reports/export-pdf-roles',
        download: true,
    },*/
    {
        title: 'Crear rol',
        href: '/panel/roles/create',
    },
];

// Form validation
const formSchema = toTypedSchema(
    z.object({
        name: z
            .string({ message: 'Campo obligatorio' })
            .min(1, { message: 'Nombre mayor a 5 letras' })
            .max(50, { message: 'Nombre menor a 50 letras' }),
    }),
);

// Form submit
const { handleSubmit } = useForm({
    validationSchema: formSchema,
});
const onSubmit = handleSubmit((values) => {
    console.log('hola')
    createRole(values);
});
</script>
<style scoped></style>