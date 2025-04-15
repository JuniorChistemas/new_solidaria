<template>
    <Dialog :open="modal" @update:open="closeModal">
        <DialogContent class="sm:max-w-[850px]">
            <DialogHeader>
                <DialogTitle>Editando el movimiento</DialogTitle>
                <DialogDescription>Los datos están validados, llenar con precaución.</DialogDescription>
            </DialogHeader>
            <form @submit="onSubmit" class="py-4">
                <div class="grid grid-cols-3 gap-4">
                    <!-- Primera columna -->
                    <FormField v-slot="{ componentField }" name="codigo">
                        <FormItem>
                            <FormLabel>Código</FormLabel>
                            <FormControl>
                                <Input id="codigo" type="text" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="fechaEmision">
                        <FormItem>
                            <FormLabel>Fecha de Emisión</FormLabel>
                            <FormControl>
                                <Input id="fechaEmision" type="date" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="fechaCredito">
                        <FormItem>
                            <FormLabel>Fecha de Crédito</FormLabel>
                            <FormControl>
                                <Input id="fechaCredito" type="date" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="idProveedor">
                        <FormItem>
                            <FormLabel>Proveedor</FormLabel>
                            <FormControl>
                                <SupplierCombobox @select="onSelectProveedor" :initialId="initialProveedorId" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField v-slot="{ componentField }" name="idUser">
                        <FormItem>
                            <FormLabel>Usuario</FormLabel>
                            <FormControl>
                                <UserCombobox @select="onSelectUser" :initialId="initialUserId" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="idTipoMovimiento">
                        <FormItem>
                        <FormLabel>Tipo de Movimiento</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                            <SelectTrigger>
                                <SelectValue placeholder="Selecciona el tipo de movimiento" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                <SelectLabel>Tipo de Movimiento</SelectLabel>
                                <SelectItem :value="1">Factura</SelectItem>
                                <SelectItem :value="2">Guía</SelectItem>
                                <SelectItem :value="3">Boleta</SelectItem>
                                <SelectItem :value="4">Venta</SelectItem>
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
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecciona el estado" />
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
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecciona el estado de IGV" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Estado IGV</SelectLabel>
                                            <SelectItem value="1">Incluye</SelectItem>
                                            <SelectItem value="2">No Incluye</SelectItem>
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
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecciona el tipo de pago" />
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
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <Button type="button" variant="outline" @click="closeModal">Cancelar</Button>
                    <Button type="submit">Guardar cambios</Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch, ref } from 'vue';
import * as z from 'zod';
import { MovementResource, MovementUpdateRequest } from '../interface/Movement';
import SupplierCombobox from '@/components/inputs/SupplierCombobox.vue';
import UserCombobox from '@/components/inputs/UserCombobox.vue';

const props = defineProps<{ modal: boolean; movementData: MovementResource }>();
const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-movement', movement: MovementUpdateRequest, id_movement: number): void;
}>();

// IDs iniciales para los comboboxes
const initialProveedorId = ref<number | null>(null);
const initialUserId = ref<number | null>(null);

// Referencias para mantener los valores seleccionados
const selectedProveedor = ref<number | null>(null);
const selectedUser = ref<number | null>(null);

const closeModal = () => emit('emit-close', false);

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        codigo: z.string().min(2, 'El código debe tener al menos 2 caracteres').max(40, 'Máximo 40 caracteres'),
        fechaEmision: z.string().min(1, 'La fecha de emisión es requerida'),
        fechaCredito: z.string().nullable(),
        idProveedor: z.number({ message: 'Seleccione un proveedor' }),
        idUser: z.number({ message: 'Seleccione un usuario' }),
        idTipoMovimiento: z.string().or(z.number()).transform(val => Number(val)),
        estado: z.string().or(z.number()).transform(val => Number(val)),
        estadoIgv: z.string().or(z.number()).transform(val => Number(val)),
        estadoIngreso: z.string().or(z.number()).transform(val => Number(val)),
        tipoPago: z.string().min(1, 'El tipo de pago es requerido'),
    }),
);

// Inicialización del formulario
const { handleSubmit, setValues, setFieldValue } = useForm({
    validationSchema: formSchema,
    initialValues: {
        codigo: props.movementData.codigo,
        fechaEmision: props.movementData.fechaEmision,
        fechaCredito: props.movementData.fechaCredito || '',
        idProveedor: props.movementData.idProveedor,
        idUser: props.movementData.idUser,
        idTipoMovimiento: props.movementData.idTipoMovimiento,
        estado: String(props.movementData.estado),
        estadoIgv: String(props.movementData.estadoIgv),
        estadoIngreso: String(props.movementData.estadoIngreso),
        tipoPago: props.movementData.tipoPago,
    },
});

// Add this function to your edit modal component
const formatDateForInput = (dateString) => {
  if (!dateString) return '';
  
  try {
    // If the date is already in ISO format (YYYY-MM-DDT...)
    if (dateString.includes('T')) {
      return dateString.split('T')[0]; // Returns YYYY-MM-DD
    }
    
    // If the date is in DD/MM/YYYY format (as displayed in the table)
    if (dateString.includes('/')) {
      const [day, month, year] = dateString.split('/');
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }
    
    return dateString;
  } catch (e) {
    console.error('Error formatting date:', e);
    return '';
  }
};

// Actualiza los valores iniciales cuando cambian los datos del movimiento
watch(
    () => props.movementData,
    (newData) => {
        if (newData) {
            // Actualizar valores del formulario
            setValues({
                codigo: newData.codigo,
                fechaEmision: formatDateForInput(newData.fechaEmision),
                fechaCredito: formatDateForInput(newData.fechaCredito),
                idProveedor: newData.idProveedor,
                idUser: newData.idUser,
                idTipoMovimiento: newData.idTipoMovimiento,
                estado: String(newData.estado),
                estadoIgv: String(newData.estadoIgv),
                estadoIngreso: String(newData.estadoIngreso),
                tipoPago: newData.tipoPago,
            });
            
            // Actualizar IDs iniciales para los comboboxes
            initialProveedorId.value = newData.idProveedor;
            initialUserId.value = newData.idUser;
            
            // Mantener valores seleccionados
            selectedProveedor.value = newData.idProveedor;
            selectedUser.value = newData.idUser;
        }
    },
    { deep: true, immediate: true },
);

// Funciones para manejar la selección en los comboboxes
const onSelectProveedor = (id: number) => {
    selectedProveedor.value = id;
    setFieldValue('idProveedor', id);
};

const onSelectUser = (id: number) => {
    selectedUser.value = id;
    setFieldValue('idUser', id);
};

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-movement', values, props.movementData.id);
    closeModal();
});

</script>