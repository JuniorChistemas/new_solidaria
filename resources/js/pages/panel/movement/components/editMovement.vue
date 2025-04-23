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
                    <FormField v-slot="{ componentField }" name="code">
                        <FormItem>
                            <FormLabel>Código</FormLabel>
                            <FormControl>
                                <Input id="codigo" type="text" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="issue_date">
                        <FormItem>
                            <FormLabel>Fecha de Emisión</FormLabel>
                            <FormControl>
                                <Input id="fechaEmision" type="date" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="credit_date">
                        <FormItem>
                            <FormLabel>Fecha de Crédito</FormLabel>
                            <FormControl>
                                <Input id="fechaCredito" type="date" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                   
                    <FormField v-slot="{ componentField }" name="supplier_id">
                        <FormItem>
                            <FormLabel>Proveedor</FormLabel>
                            <FormControl>
                                <SupplierCombobox @select="onSelectProveedor" :initialId="initialProveedorId" />
                            </FormControl>
                            <!-- Información actual del proveedor -->
                            <div v-if="movementData.supplier" class="mt-1 text-xs font-medium text-blue-600 dark:text-blue-400 flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 rounded-full bg-blue-400 dark:bg-blue-600"></span>
                                Actual: {{ movementData.supplier.name }}
                            </div>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="user_id">
                        <FormItem>
                            <FormLabel>Usuario</FormLabel>
                            <FormControl>
                                <UserCombobox @select="onSelectUser" :initialId="initialUserId" />
                            </FormControl>
                            <!-- Información actual del usuario -->
                            <div v-if="movementData.user" class="mt-1 text-xs font-medium text-blue-600 dark:text-blue-400 flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 rounded-full bg-blue-400 dark:bg-blue-600"></span>
                                Actual: {{ movementData.user.name }}
                            </div>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="type_movement_id">
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
                    <FormField v-slot="{ componentField }" name="igv_status">
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
                    <FormField v-slot="{ componentField }" name="payment_type">
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
import SupplierCombobox from '@/components/Inputs/SupplierCombobox.vue';
import UserCombobox from '@/components/Inputs/UserCombobox.vue';

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

// Función para obtener la etiqueta del estado
const getStatusLabel = (status: number): string => {
    switch(status) {
        case 0: return 'Eliminado';
        case 1: return 'Activo';
        case 2: return 'Anulado';
        default: return 'Desconocido';
    }
};

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        code: z.string().min(2, 'El código debe tener al menos 2 caracteres').max(40, 'Máximo 40 caracteres'),
        issue_date: z.string().min(1, 'La fecha de emisión es requerida'),
        credit_date: z.string().nullable(),
        supplier_id: z.number({ message: 'Seleccione un proveedor' }),
        user_id: z.number({ message: 'Seleccione un usuario' }),
        type_movement_id: z.string().or(z.number()).transform(val => Number(val)),
        status: z.string().or(z.number()).transform(val => Number(val)),
        igv_status: z.string().or(z.number()).transform(val => Number(val)),
        payment_type: z.string().min(1, 'El tipo de pago es requerido'),
    }),
);

// Inicialización del formulario
const { handleSubmit, setValues, setFieldValue } = useForm({
    validationSchema: formSchema,
    initialValues: {
        code: props.movementData.code,
        issue_date: props.movementData.issue_date,
        credit_date: props.movementData.credit_date || '',
        supplier_id: props.movementData.supplier_id,
        user_id: props.movementData.user_id,
        type_movement_id: props.movementData.type_movement_id,
        status: String(props.movementData.status),
        igv_status: String(props.movementData.igv_status),
        payment_type: props.movementData.payment_type,
    },
});

// Función para formatear fechas para inputs
const formatDateForInput = (dateString) => {
  if (!dateString) return '';
  
  try {
    // Si la fecha ya está en formato ISO (YYYY-MM-DDT...)
    if (dateString.includes('T')) {
      return dateString.split('T')[0]; // Devuelve YYYY-MM-DD
    }
    
    // Si la fecha está en formato DD/MM/YYYY (como se muestra en la tabla)
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
                code: newData.code,
                issue_date: formatDateForInput(newData.issue_date),
                credit_date: formatDateForInput(newData.credit_date),
                supplier_id: newData.supplier_id,
                user_id: newData.user_id,
                type_movement_id: newData.type_movement_id,
                status: String(newData.status),
                igv_status: String(newData.igv_status),
                payment_type: newData.payment_type,
            });
            
            // Actualizar IDs iniciales para los comboboxes
            initialProveedorId.value = newData.supplier_id;
            initialUserId.value = newData.user_id;
            
            // Mantener valores seleccionados
            selectedProveedor.value = newData.supplier_id;
            selectedUser.value = newData.user_id;
        }
    },
    { deep: true, immediate: true },
);

// Funciones para manejar la selección en los comboboxes
const onSelectProveedor = (id: number) => {
    selectedProveedor.value = id;
    setFieldValue('supplier_id', id);
};

const onSelectUser = (id: number) => {
    selectedUser.value = id;
    setFieldValue('user_id', id);
};

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-movement', values, props.movementData.id);
    closeModal();
});
</script>