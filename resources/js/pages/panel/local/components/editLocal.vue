<template>
  <Dialog :open="modal" @update:open="clouseModal">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>Editando el Local</DialogTitle>
        <DialogDescription>Los datos están validados, llenar con precaución.</DialogDescription>
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

        <FormField v-slot="{ componentField }" name="address">
          <FormItem>
            <FormLabel>Dirección</FormLabel>
            <FormControl>
              <Input id="address" type="text" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="series">
          <FormItem>
            <FormLabel>Serie</FormLabel>
            <FormControl>
              <Input id="series" type="text" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="series_note">
          <FormItem>
            <FormLabel>Nota de la Serie</FormLabel>
            <FormControl>
              <Input id="series_note" type="text" v-bind="componentField" />
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

        <DialogFooter>
          <Button type="submit">Guardar cambios</Button>
          <Button type="button" variant="outline" @click="clouseModal">Cancelar</Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';

import { LocalResource, LocalUpdateRequest } from '../interface/Local';

const props = defineProps<{ modal: boolean; localData: LocalResource }>();
const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-local', local: LocalUpdateRequest, id_local: number): void;
}>();

const clouseModal = () => emit('emit-close', false);

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2, 'El nombre debe tener al menos 2 caracteres').max(50, 'Máximo 50 caracteres'),
        address: z.string().min(5, 'La dirección debe tener al menos 5 caracteres').max(255, 'Máximo 255 caracteres'),
        series: z.string().min(1, 'La serie es requerida').max(50, 'Máximo 50 caracteres'),
        series_note: z.string().optional(),
        status: z.enum(['activo', 'inactivo']),
    })
);

// Inicialización del formulario
const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: props.localData.name,
        address: props.localData.address,
        series: props.localData.series,
        series_note: props.localData.series_note,
        status: props.localData.status ? 'activo' : 'inactivo',
    },
});

watch(
    () => props.localData,
    (newData) => {
        if (newData) {
            setValues({
                name: newData.name,
                address: newData.address,
                series: newData.series,
                series_note: newData.series_note,
                status: newData.status ? 'activo' : 'inactivo',
            });
        }
    },
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-local', values, props.localData.id);
    clouseModal();
});
</script>
