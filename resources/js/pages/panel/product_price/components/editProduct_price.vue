<template>
    <Dialog :open="modal" @update:open="clouseModal">
        <DialogContent class="w-full max-w-4xl">
            <DialogHeader>
                <DialogTitle>Editar</DialogTitle>
                <DialogDescription>
                    <p class="text-sm text-muted-foreground">Edita los datos del producto</p>
                </DialogDescription>
            </DialogHeader>
            <form @submit="onSubmit" class="flex flex-col gap-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> <!-- Grilla para dos columnas -->
                    <FormField v-slot="{ componentField }" name="product_id">
                        <FormItem>
                            <FormLabel>Nombre</FormLabel>
                            <FormControl>
                                <Select v-bind="componentField">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Selecciona el producto" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Producto</SelectLabel>
                                            <SelectItem v-for="type in props.product" :key="type.id" :value="type.id">
                                                {{ type.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                <FormField v-slot="{ componentField }" name="box_price">
                  <FormItem>
                      <FormLabel>Precio por caja</FormLabel>
                      <FormControl>
                          <Input 
                              id="cost" 
                              type="number" 
                              step="0.01" 
                              v-bind="componentField" 
                          />
                      </FormControl>
                      <FormMessage />
                  </FormItem>
              </FormField>
              <FormField v-slot="{ componentField }" name="fraction_price">
                  <FormItem>
                      <FormLabel>Precio por fraccion</FormLabel>
                      <FormControl>
                          <Input 
                              id="cost" 
                              type="number" 
                              step="0.01" 
                              v-bind="componentField" 
                          />
                      </FormControl>
                      <FormMessage />
                  </FormItem>
              </FormField>
                </div> 

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
import { InputProduct} from '@/interface/Inputs';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm} from 'vee-validate';
import { watch, computed } from 'vue';
import { z } from 'zod';
import { ProductpriceRequestUpdate, ProductpriceResource } from '../interface/Product_price';

const props = defineProps<{
    modal: boolean;
    productpriceData: ProductpriceResource;
    product: InputProduct[];
}>();



const emit = defineEmits<{
    (e: 'closeModal', open: boolean): void;
    (e: 'updateProduct', productpriceData: ProductpriceRequestUpdate, product_id: number): void;
}>();

const clouseModal = () => {
    emit('closeModal', false);
};

const formShema = toTypedSchema(
    z.object({
        product_id: z.number({ message: 'campo obligatorio' }),
            box_price: z.number({ message: 'campo obligatorio' }),
            fraction_price: z.number({ message: 'campo obligatorio' }),
            }),
);

const { handleSubmit, setValues  } = useForm({
    validationSchema: formShema,
    initialValues: {
        product_id: props.productpriceData.product_id,
        box_price: props.productpriceData.box_price,
        fraction_price: props.productpriceData.fraction_price,

    },
});

watch(
    () => props.productpriceData,
    (newData) => {
        if (newData) {
            setValues({
        product_id: newData.product_id,
        box_price: newData.box_price,
        fraction_price: newData.fraction_price,
            });
        }
    },
    
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    const updatedProduct: ProductpriceRequestUpdate = {
        product_id: values.product_id,
        box_price: values.box_price,
        fraction_price: values.fraction_price,
    };
    emit('updateProduct', updatedProduct, props.productpriceData.id);
    clouseModal();
});
</script>
<style scoped></style>
