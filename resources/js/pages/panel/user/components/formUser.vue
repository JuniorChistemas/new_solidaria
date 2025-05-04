<template>
    <Head title="Nuevo Usuario"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO USUARIO</CardTitle>
                    <CardDescription>Complete los campos para registrar un nuevo usuario</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="onSubmit" class="flex flex-col gap-6">
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Nombre</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Nombre" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="email">
                            <FormItem>
                                <FormLabel>Email</FormLabel>
                                <FormControl>
                                    <Input type="email" placeholder="Email" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="username">
                            <FormItem>
                                <FormLabel>Nombre de usuario</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Nombre de usuario" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField name="local_id">
                            <FormItem>
                                <FormLabel>Local</FormLabel>
                                <FormControl>
                                    <LocalSelect @local_id="(id) => setFieldValue('local_id', id)" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="password">
                            <FormItem>
                                <FormLabel>Contraseña</FormLabel>
                                <FormControl>
                                    <Input type="password" placeholder="Contraseña" v-bind="componentField" />
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
                                            <SelectValue placeholder="Seleccionar estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Estado</SelectLabel>
                                                <SelectItem value="true"> Activo</SelectItem>
                                                <SelectItem value="false"> Inactivo</SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                            </FormItem>
                        </FormField>
                        <FormField name="role_name">
                            <FormItem>
                                <FormLabel>Rol</FormLabel>
                                <FormControl>
                                    <RoleSelect @role_name="(name) => setFieldValue('role_name', name)" />
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
import LocalSelect from '@/components/Inputs/LocalSelect.vue';
import RoleSelect from '@/components/Inputs/RoleSelect.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FormControl, FormField, FormLabel } from '@/components/ui/form';
import FormItem from '@/components/ui/form/FormItem.vue';
import FormMessage from '@/components/ui/form/FormMessage.vue';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useUser } from '@/composables/useUser';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { z } from 'zod';
import { UserRequest } from '../interface/User';

const { storeUser, message } = useUser();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Usuarios',
        href: '/panel/users',
    },
    {
        title: 'Nuevo Usuario',
        href: '/panel/users/create',
    },
];

const formShema = toTypedSchema(
    z.object({
        name: z.string().min(3, 'El nombre es requerido'),
        email: z.string().email('El email no es válido').min(3, 'El email es requerido'),
        username: z.string().min(3, 'El nombre de usuario es requerido'),
        local_id: z.number().min(1, 'El local es requerido'),
        password: z.string().min(6, 'La contraseña es requerida'),
        status: z.string(),
        role_name: z.string().min(1, 'El rol es requerido'),
    }),
);

const { handleSubmit, setFieldValue } = useForm({
    validationSchema: formShema,
    initialValues: {
        name: '',
        email: '',
        username: '',
        local_id: 0,
        password: '',
        status: 'true',
        role_name: '',
    },
});

// send data to the component father

const onSubmit = handleSubmit((values) => {
    // console.log('Formulario enviado con:', values);
    const userData: UserRequest = {
        ...values,
        status: values.status === 'true' ? true : false,
    };
    console.log(values);

    storeUser(userData);
});
</script>
<style scoped></style>
