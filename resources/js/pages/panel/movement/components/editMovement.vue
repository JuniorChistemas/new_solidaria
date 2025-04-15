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
                    
                    <FormField v-slot="{ componentField }" name="fechaEjecucion">
                        <FormItem>
                            <FormLabel>Fecha de Ejecución</FormLabel>
                            <FormControl>
                                <Input id="fechaEjecucion" type="date" v-bind="componentField" />
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
                                <Input id="idProveedor" type="number" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="idLocal">
                        <FormItem>
                            <FormLabel>Local</FormLabel>
                            <FormControl>
                                <Input id="idLocal" type="number" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    
                    <FormField v-slot="{ componentField }" name="idTipoMovimiento">
                        <FormItem>
                            <FormLabel>Tipo de Movimiento</FormLabel>
                            <FormControl>
                                <Input id="idTipoMovimiento" type="number" v-bind="componentField" />
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
                    
                    <FormField v-slot="{ componentField }" name="estadoIngreso">
                        <FormItem>
                            <FormLabel>Estado Ingreso</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecciona el estado de ingreso" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Estado Ingreso</SelectLabel>
                                            <SelectItem value="1">Ingreso</SelectItem>
                                            <SelectItem value="0">Salida</SelectItem>
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
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';
import { MovementResource, MovementUpdateRequest } from '../interface/Movement';

const props = defineProps<{ modal: boolean; movementData: MovementResource }>();
const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-movement', movement: MovementUpdateRequest, id_movement: number): void;
}>();

const closeModal = () => emit('emit-close', false);

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        codigo: z.string().min(2, 'El código debe tener al menos 2 caracteres').max(40, 'Máximo 40 caracteres'),
        fechaEmision: z.string().min(1, 'La fecha de emisión es requerida'),
        fechaEjecucion: z.string().min(1, 'La fecha de ejecución es requerida'),
        fechaCredito: z.string().nullable(),
        idProveedor: z.string().or(z.number()),
        idLocal: z.string().or(z.number()),
        idUser: z.string().or(z.number()),
        idTipoMovimiento: z.string().or(z.number()),
        estado: z.string().or(z.number()),
        estadoIgv: z.string().or(z.number()),
        estadoIngreso: z.string().or(z.number()),
        tipoPago: z.string().min(1, 'El tipo de pago es requerido'),
    }),
);

// Inicialización del formulario
const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
    initialValues: {
        codigo: props.movementData.codigo,
        fechaEmision: props.movementData.fechaEmision,
        fechaEjecucion: props.movementData.fechaEjecucion,
        fechaCredito: props.movementData.fechaCredito || '',
        idProveedor: props.movementData.idProveedor,
        idLocal: props.movementData.idLocal,
        idUser: props.movementData.idUser,
        idTipoMovimiento: props.movementData.idTipoMovimiento,
        estado: String(props.movementData.estado),
        estadoIgv: String(props.movementData.estadoIgv),
        estadoIngreso: String(props.movementData.estadoIngreso),
        tipoPago: props.movementData.tipoPago,
    },
});

watch(
    () => props.movementData,
    (newData) => {
        if (newData) {
            setValues({
                codigo: newData.codigo,
                fechaEmision: newData.fechaEmision,
                fechaEjecucion: newData.fechaEjecucion,
                fechaCredito: newData.fechaCredito || '',
                idProveedor: newData.idProveedor,
                idLocal: newData.idLocal,
                idUser: newData.idUser,
                idTipoMovimiento: newData.idTipoMovimiento,
                estado: String(newData.estado),
                estadoIgv: String(newData.estadoIgv),
                estadoIngreso: String(newData.estadoIngreso),
                tipoPago: newData.tipoPago,
            });
        }
    },
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-movement', values, props.movementData.id);
    closeModal();
});
</script>