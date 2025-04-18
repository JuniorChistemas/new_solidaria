<template>
    <Head title="Nuevo Producto"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Alert v-if="hasErrors" variant="destructive">
                <AlertCircle class="h-4 w-4"></AlertCircle>
                <AlertTitle>Error</AlertTitle>
                <AlertDescription>
                    <ul class="mt-2 list-inside list-disc text-sm">
                        <li v-for="(message, field) in page.props.errors" :key="field">
                            {{ message }}
                        </li>
                    </ul>
                </AlertDescription>
            </Alert>
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO PRODUCTO</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo producto</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Nombre</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="nombre y apellidos" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="composition">
                            <FormItem>
                                <FormLabel>Composición</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="colocar composición" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="presentation">
                            <FormItem>
                                <FormLabel>Presentación</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="colocar presentacion" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="form_farm">
                            <FormItem>
                                <FormLabel>Formula Farmacia</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Coloca la formula" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-slot="{ componentField }" name="barcode">
                            <FormItem>
                                <FormLabel>Código de Barras</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Coloca el código" v-bind="componentField" />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-if="props.laboratories" v-slot="{ componentField }" name="laboratory_id">
                            <FormItem>
                                <FormLabel>Laboratorio</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Selecciona el laboratorio" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Laboratorio</SelectLabel>
                                                <SelectItem v-for="type in props.laboratories" :key="type.id" :value="type.id">
                                                    {{ type.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>
                        <FormField v-if="props.categories" v-slot="{ componentField }" name="category_id">
                            <FormItem>
                                <FormLabel>Categoria</FormLabel>
                                <FormControl>
                                    <Select v-bind="componentField">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Selecciona una categoria" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>Categoria</SelectLabel>
                                                <SelectItem v-for="type in props.categories" :key="type.id" :value="type.id">
                                                    {{ type.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>   
                        <FormField v-slot="{ componentField }" name="state_fraction">
                    <FormItem>
                        <FormLabel>Fraccion</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona una opción" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Fraccion</SelectLabel>
                                        <SelectItem value="fraccionable">Fraccionable</SelectItem>
                                        <SelectItem value="no fraccionable">No fraccionable</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="state_igv">
                    <FormItem>
                        <FormLabel>IGV</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona una opcion" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>IGV</SelectLabel>
                                        <SelectItem value="afectado">Afectado</SelectItem>
                                        <SelectItem value="inafectado">Inafectado</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
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
                        <Button type="submit">Crear Producto</Button>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
//composable
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useProduct } from '@/composables/useProduct';
import { InputLaboratory } from '@/interface/Inputs';
import { InputCategory } from '@/interface/Inputs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { AlertCircle } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { computed} from 'vue';
import { z } from 'zod';
const { createProduct } = useProduct();
const page = usePage<SharedData>();

const props = defineProps<{
    laboratories: InputLaboratory[];
    categories: InputCategory[];

}>();

const hasErrors = computed(() => {
    return page.props.errors && Object.keys(page.props.errors).length > 0;
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Productos',
        href: '/panel/products',
    },
    {
        title: 'Exportar',
        href: '/panel/users/export',
    },
    {
        title: 'Crear producto',
        href: '/panel/products/create',
    },
];

// Form validation

const formShema = toTypedSchema(
    z.object({
        name: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'nombre mayor a 2 letras' })
            .max(150, { message: 'nombre menor a 150 letras' }),
        composition: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'composicion mayor a 2 letras' })
            .max(300, { message: 'composicion menor a 300 letras' }),
        presentation: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'presentacion mayor a 2 letras' })
            .max(400, { message: 'presentacion menor a 400 letras' }),
        form_farm: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'formula mayor a 2 letras' })
            .max(200, { message: 'formula menor a 200 letras' }),
        barcode: z
            .string({ message: 'campo obligatorio' })
            .min(1, { message: 'codigo mayor a 2 letras' })
            .max(8, { message: 'codigo menor a 9 letras' }),
        laboratory_id: z.number({ message: 'campo obligatorio' }),
        category_id: z.number({ message: 'campo obligatorio' }),
        state_fraction: z.enum(['fraccionable', 'no fraccionable'], { message: 'Estado inválido' }),
        state_igv: z.enum(['afectado', 'inafectado'], { message: 'Estado inválido' }),
        state: z.enum(['activo', 'inactivo'], { message: 'Estado inválido' }),
    }),
);

const { handleSubmit } = useForm({
    validationSchema: formShema,
    initialValues: {         
        state: 'activo',     
    },
});

const onSubmit = handleSubmit((values) => {
    const productData= {
        name: values.name,
        composition: values.composition,
        presentation: values.presentation,
        form_farm: values.form_farm,
        barcode: values.barcode,
        laboratory_id: values.laboratory_id,
        category_id: values.category_id,
        state_fraction: values.state_fraction === 'fraccionable',
        state_igv: values.state_igv === 'afectado',
        state: values.state === 'activo',
    };
    
    createProduct(productData);
});
</script>
<style scoped></style>
