<template>
    <Dialog :open="modal" @update:open="clouseModal">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Editar Producto</DialogTitle>
                <DialogDescription>
                    <p class="text-sm text-muted-foreground">Edita los datos del producto</p>
                </DialogDescription>
            </DialogHeader>
            <form @submit="onSubmit" class="flex flex-col gap-4 py-4">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem>
                        <FormLabel>Nombre</FormLabel>
                        <FormControl>
                            <Input id="name" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="composition">
                    <FormItem>
                        <FormLabel>Composición</FormLabel>
                        <FormControl>
                            <Input id="composition" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="presentation">
                    <FormItem>
                        <FormLabel>Presentación</FormLabel>
                        <FormControl>
                            <Input id="presentation" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="form_farm">
                    <FormItem>
                        <FormLabel>Form_farm</FormLabel>
                        <FormControl>
                            <Input id="form_farm" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="barcode">
                    <FormItem>
                        <FormLabel>Código de Barras</FormLabel>
                        <FormControl>
                            <Input id="barcode" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="laboratory_id">
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
                                        <SelectItem v-for="type in props.laboratory" :key="type.id" :value="type.id">
                                            {{ type.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="category_id">
                    <FormItem>
                        <FormLabel>Categoria</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona la categoria" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Categoria</SelectLabel>
                                        <SelectItem v-for="type in props.category" :key="type.id" :value="type.id">
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
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona el estado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Estado</SelectLabel>
                                        <SelectItem value="activo">Activo</SelectItem>
                                        <SelectItem value="inactivo">Inactivo</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <DialogFooter class="flex justify-end gap-2">
                    <Button type="submit">Guardar Cambios</Button>
                    <Button type="button" variant="outline" @click="clouseModal">Cancelar</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { InputLaboratory, InputCategory } from '@/interface/Inputs';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import { z } from 'zod';
import { ProductRequestUpdate, ProductResource } from '../interface/Product';

const props = defineProps<{
    modal: boolean;
    productData: ProductResource;
    laboratory: InputLaboratory[];
    category: InputCategory[];
}>();

const emit = defineEmits<{
    (e: 'closeModal', open: boolean): void;
    (e: 'updateProduct', productData: ProductRequestUpdate, product_id: number): void;
}>();

const clouseModal = () => {
    emit('closeModal', false);
};

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

const { handleSubmit, setValues } = useForm({
    validationSchema: formShema,
    initialValues: {
        name: props.productData.name,
        composition: props.productData.composition,
        presentation: props.productData.presentation,
        form_farm: props.productData.form_farm,
        barcode: props.productData.barcode,
        laboratory_id: props.productData.laboratory_id,
        category_id: props.productData.category_id,
        state_fraction: props.productData.state_fraction ? 'fraccionable' : 'no fraccionable',
        state_igv: props.productData.state_igv ? 'afectado' : 'inafectado',
        state: props.productData.state ? 'activo' : 'inactivo',
    },
});

watch(
    () => props.productData,
    (newData) => {
        if (newData) {
            setValues({
    name: newData.name,
    composition: newData.composition,
    presentation: newData.presentation,
    form_farm: newData.form_farm,
    barcode: newData.barcode, 
    laboratory_id: newData.laboratory_id,
    category_id: newData.category_id,
    state_fraction: newData.state_fraction ? 'fraccionable' : 'no fraccionable',
    state_igv: newData.state_igv ? 'afectado' : 'inafectado',
    state: newData.state ? 'activo' : 'inactivo',
            });
        }
    },
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    const updatedProduct: ProductRequestUpdate = {
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
    emit('updateProduct', updatedProduct, props.productData.id);
    clouseModal();
});
</script>
<style scoped></style>
