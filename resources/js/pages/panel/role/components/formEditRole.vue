<template>

    <Head title="Nueva "></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>Editar Rol</CardTitle>
                    <CardDescription>Modifique los campos para editar el rol</CardDescription>
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

                        <FormField v-slot="{ componentField }" name="permisos">
                            <FormItem>
                                <FormLabel></FormLabel>
                                <FormControl>
                                    <div class="flex gap-4">
                                        <!-- Permisos Disponibles -->
                                        <div class="flex flex-col flex-[4]">
                                            <span class="font-semibold mb-3 text-sm">Permisos Disponibles:</span>
                                            <div class="flex flex-col border rounded p-3 h-64 overflow-y-auto">
                                                <div v-for="permiso in availablePermissions" :key="permiso.id" class="cursor-pointer hover:bg-gray-800 px-2 py-1 rounded" @click="moveToAssigned(permiso)">
                                                    {{ permiso.name }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Botones -->
                                        <div class="flex items-center justify-center flex-[1]">
                                            <div class="flex flex-col gap-3">
                                                <Button type="button" variant="secondary" @click="availablePermissions.forEach(p => moveToAssigned(p))">
                                                    <ChevronsRight style="width: 20px; height: 20px;"/>
                                                </Button>
                                                <Button type="button" variant="secondary" @click="assignedPermissions.forEach(p => moveToAvailable(p))">
                                                    <ChevronsLeft style="width: 20px; height: 20px;"/>
                                                </Button>
                                            </div>
                                        </div>

                                        <!-- Permisos Asignados -->
                                        <div class="flex flex-col flex-[4]">
                                            <span class="font-semibold mb-3 text-sm">Permisos Asignados:</span>
                                            <div class="flex flex-col border rounded p-2 h-64 overflow-y-auto">
                                                <div v-for="permiso in assignedPermissions" :key="permiso.id" class="cursor-pointer hover:bg-gray-800 px-2 py-1 rounded" @click="moveToAvailable(permiso)">
                                                    {{ permiso.name }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <div class="container flex justify-end gap-4 m-3">
                            <Button type="submit" variant="default"> Actualizar </Button>
                            <Button type="button" variant="destructive" @click="cancelEdit"> Cancelar </Button>
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
import { Head, router } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';
import { ref, onMounted, watch } from 'vue'; 
// composable
import { useRole } from '@/composables/useRole';
import { showSuccessMessage } from '@/utils/message';
import { ChevronsRight, ChevronsLeft  } from 'lucide-vue-next';


// Definir props primero
const props = defineProps<{
    permisos: { id: number; name: string }[];  // Todos los permisos disponibles
    roleData: { id: number; name: string; permisos: { id: number; name: string }[] };  // Información del rol
}>();

const { updateRole } = useRole();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/panel/roles',
    },
    {
        title: 'Editar Rol',
        href: '/panel/roles/edit',
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
    initialValues: {
        name: props.roleData.name,
    },
});

const availablePermissions = ref<{ id: number; name: string }[]>([]);
const assignedPermissions = ref<{ id: number; name: string }[]>([]);

// Enviar formulario
const onSubmit = handleSubmit(async (values) => { 
    await updateRole(props.roleData.id, {
        name: values.name,
        permisos: assignedPermissions.value.map(p => p.id)
    });

    router.visit(route('panel.roles.index'), {
        method: 'get',
        data: {},
        preserveScroll: true,
        onSuccess: () => {
            showSuccessMessage('Rol actualizado', 'El rol se actualizó correctamente');
        }
    });
    
    console.log('Rol actualizado:', values.name, assignedPermissions.value);

});

// Cargar datos cuando llegan
watch(() => props.roleData, (newVal) => {
    if (newVal) {
        assignedPermissions.value = newVal.permisos;
        availablePermissions.value = props.permisos.filter(
            (p) => !newVal.permisos.some((ap) => ap.id === p.id)
        );
    }
}, { immediate: true, deep: true });

// Inicializar valores y permisos al montar el componente
onMounted(() => {
   assignedPermissions.value = props.roleData.permisos;
   availablePermissions.value = props.permisos.filter(
        (p) => !assignedPermissions.value.some((ap) => ap.id === p.id)
    );
});

// Cancelar edición y redirigir al index
const cancelEdit = () => {
    router.visit(route('panel.roles.index'));
};

const moveToAssigned = (permiso: { id: number; name: string }) => {
    assignedPermissions.value.push(permiso);
    availablePermissions.value = availablePermissions.value.filter(p => p.id !== permiso.id);
};

const moveToAvailable = (permiso: { id: number; name: string }) => {
    availablePermissions.value.push(permiso);
    assignedPermissions.value = assignedPermissions.value.filter(p => p.id !== permiso.id);
};


console.log(props.permisos);

</script>

<style scoped></style>