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

                        <!-- Permisos -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Permisos</label>
                            <div class="grid grid-cols-3 gap-4">
                                <div v-for="permiso in props.permisos" :key="permiso.id" class="flex items-center">
                                    <input type="checkbox" :value="permiso.id" v-model="selectedPermissions" class="mr-2">
                                    {{ permiso.name }}
                                </div>
                            </div>
                        </div>

                        <div class="container flex justify-end gap-4">
                            <Button type="submit" variant="default"> Enviar </Button>
                            <Button type="reset" variant="outline" @click="resetPermissions"> Borrar </Button>
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
import { ref, onMounted } from 'vue'; 
// composable
import { useRole } from '@/composables/useRole';
const { createRole } = useRole();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/panel/roles',
    },
    {
        title: 'Crear Rol',
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

const selectedPermissions = ref<number[]>([]);  // Aquí está la definición de ref

// Manejo de formulario
const onSubmit = handleSubmit(async (values) => {
    // Llamada al composable para crear el rol
    await createRole({
        name: values.name,
        permisos: selectedPermissions.value, // Aquí pasamos los permisos seleccionados (IDs)
    });
    console.log('Rol creado con permisos:', selectedPermissions.value);
});

const props = defineProps<{
    permisos: {
        id: number;
        name: string;
    }[]; // Definir los permisos como un array de objetos con id y name
}>();
// Al cargar el componente, seleccionamos todos los permisos por defecto
onMounted(() => {
    //selectedPermissions.value = props.permisos.map(permiso => permiso.id);
});

// Reset selectedPermissions when clicking "Borrar"
const resetPermissions = () => {
    selectedPermissions.value = [];
};

console.log(props.permisos);


</script>

<style scoped></style>