<template>
  <Head title="Nuevo Local"></Head>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <Card class="mt-4 flex flex-col gap-4">
        <CardHeader>
          <CardTitle>NUEVO LOCAL</CardTitle>
          <CardDescription>Complete los campos para crear un nuevo local</CardDescription>
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

            <FormField v-slot="{ componentField }" name="address">
              <FormItem>
                <FormLabel>Dirección</FormLabel>
                <FormControl>
                  <Input type="text" placeholder="Dirección" v-bind="componentField" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="series">
              <FormItem>
                <FormLabel>Serie</FormLabel>
                <FormControl>
                  <Input type="text" placeholder="Serie" v-bind="componentField" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="series_note">
              <FormItem>
                <FormLabel>Nota de la Serie</FormLabel>
                <FormControl>
                                   <Input type="text" placeholder="Nota de la Serie" v-bind="componentField" />

                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="status">
              <FormItem>
                <FormLabel>Estado</FormLabel>
                <FormControl>
                  <Select v-bind="componentField" class="w-full rounded-md border border-slate-950 p-2">
                    <SelectTrigger class="w-full">
                      <SelectValue placeholder="Seleccione el estado" />
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

// Composable
import { useLocal } from '@/composables/useLocal';
const { createLocal } = useLocal();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Locales',
    href: '/panel/locals',
  },
  {
    title: 'Crear Local',
    href: '/panel/locals/create',
  },
];

// Esquema de validación
const formSchema = toTypedSchema(
  z.object({
    name: z
      .string({ message: 'Campo obligatorio' })
      .min(1, { message: 'El nombre debe tener al menos 1 carácter' })
      .max(50, { message: 'El nombre debe ser menor a 50 caracteres' }),
    address: z
      .string({ message: 'Campo obligatorio' })
      .min(5, { message: 'La dirección debe tener al menos 5 caracteres' })
      .max(255, { message: 'La dirección debe ser menor a 255 caracteres' }),
    series: z
      .string({ message: 'Campo obligatorio' })
      .min(1, { message: 'La serie es requerida' })
      .max(50, { message: 'La serie debe ser menor a 50 caracteres' }),
    series_note: z.string().optional(),
    status: z.enum(['activo', 'inactivo'], { message: 'Estado inválido' }),
  })
);

// Inicialización del formulario
const { handleSubmit } = useForm({
  validationSchema: formSchema,
});

// Envío del formulario
const onSubmit = handleSubmit((values) => {
  console.log('Enviando formulario con:', values);
  createLocal(values);
});
</script>

<style scoped></style>
