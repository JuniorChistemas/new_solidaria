<template>
    <Dialog :open="statusModal" @update:open="closeModal">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Editar usuario</DialogTitle>
                <DialogDescription>
                    <p class="text-sm text-muted-foreground">Edita los datos del usuario</p>
                </DialogDescription>
                <form @submit.prevent="onSubmit" class="flex flex-col gap-4 py-3">
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Nombre</FormLabel>
                            <FormControl>
                                <Input id="name" type="text" v-bind="componentField" />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input id="email" type="text" v-bind="componentField" />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>Nombre de usuario</FormLabel>
                            <FormControl>
                                <Input id="username" type="text" v-bind="componentField" />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField name="local_id">
                        <FormItem>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow space-y-2">
                                    <FormLabel>Local</FormLabel>
                                    <FormControl>
                                        <LocalSelect @local_id="(id) => setFieldValue('local_id', id)" />
                                    </FormControl>
                                </div>
                                <span
                                    class="ml-4 self-end rounded-md bg-primary/10 px-2 py-2 text-sm font-medium text-primary dark:bg-primary dark:text-primary-foreground"
                                >
                                    {{ props.user_data.local }}
                                </span>
                            </div>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel>Contraseña</FormLabel>
                            <FormControl>
                                <Input id="password" type="password" v-bind="componentField" />
                            </FormControl>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="status">
                        <FormItem>
                            <Select id="status" v-bind="componentField">
                                <FormLabel>Estado</FormLabel>
                                <SelectTrigger>
                                    <SelectValue :placeholder="props.user_data.status ? 'Activo' : 'Inactivo'" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="activo">Activo</SelectItem>
                                    <SelectItem value="inactivo">Inactivo</SelectItem>
                                </SelectContent>
                            </Select>
                        </FormItem>
                    </FormField>
                    <FormField name="role_name">
                        <FormItem>
                            <div class="flex items-center justify-between">
                                <div class="flex-grow space-y-2">
                                    <FormLabel>Local</FormLabel>
                                    <FormControl>
                                        <RoleSelect @role_name="(name) => setFieldValue('role_name', name)" />
                                    </FormControl>
                                </div>
                                <span
                                    class="ml-4 self-end rounded-md bg-primary/10 px-2 py-2 text-sm font-medium text-primary dark:bg-primary dark:text-primary-foreground"
                                >
                                    {{ props.user_data.role }}
                                </span>
                            </div>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <div class="container flex justify-end gap-4">
                        <Button type="submit" variant="ghost">Actualizar</Button>
                        <Button type="button" variant="secondary" @click="closeModal">Cancelar</Button>
                    </div>
                </form>
            </DialogHeader>
        </DialogContent>
    </Dialog>
</template>
<script setup lang="ts">
import LocalSelect from '@/components/Inputs/LocalSelect.vue';
import RoleSelect from '@/components/Inputs/RoleSelect.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import { z } from 'zod';
import { UserResource, UserUpdateRequest } from '../interface/User';

const props = defineProps<{
    statusModal: boolean;
    user_data: UserResource;
}>();

const emit = defineEmits<{
    (e: 'close-modal', open: boolean): void;
    (e: 'update-user', user_update: UserUpdateRequest, user_id: number): void;
}>();
// closeModal
const closeModal = () => {
    emit('close-modal', false);
};

const formShema = toTypedSchema(
    z.object({
        name: z.string().min(3, 'El nombre es requerido'),
        email: z.string().email('El email no es válido').min(3, 'El email es requerido'),
        username: z.string().min(3, 'El nombre de usuario es requerido'),
        local_id: z.number().nullable().default(null),
        password: z.string().nullable().default(null),
        status: z.string(),
        role_name: z.string().min(1, 'El rol es requerido'),
    }),
);

const { handleSubmit, setValues, setFieldValue } = useForm({
    validationSchema: formShema,
    initialValues: {
        name: props.user_data.name,
        email: props.user_data.email,
        username: props.user_data.username,
        local_id: null,
        password: null,
        status: props.user_data.status ? 'activo' : 'inactivo',
        role_name: props.user_data.role,
    },
});

watch(
    () => props.user_data,
    (newValue) => {
        setValues({
            name: newValue.name,
            email: newValue.email,
            username: newValue.username,
            local_id: null,
            password: null,
            status: newValue.status ? 'activo' : 'inactivo',
            role_name: newValue.role,
        });
    },
    { immediate: true },
);

const onSubmit = handleSubmit((values) => {
    const user_update: UserUpdateRequest = {
        name: values.name,
        email: values.email,
        username: values.username,
        local_id: Number(values.local_id) || null,
        password: values.password || null,
        status: values.status === 'activo' ? true : false,
        role_name: values.role_name || null,
    };
    console.log(user_update);
    emit('update-user', user_update, props.user_data.id);
});
</script>
<style scoped></style>
