<template>
  <Dialog :open="props.modal" @update:open="emit('closeModal', false)">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle>{{ props.title }}</DialogTitle>
        <DialogDescription>{{ props.description }}</DialogDescription>
      </DialogHeader>
      <div class="flex justify-end gap-2">
        <Button variant="outline" @click="emit('closeModal', false)">
          {{ props.cancelButtonText }}
        </Button>
        <Button variant="destructive" @click="emit('deleteItem', props.itemId)">
          {{ props.confirmButtonText }}
        </Button>
      </div>
    </DialogContent>
  </Dialog>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';

const props = withDefaults(defineProps<{
  modal: boolean;
  itemId: number | string;
  title?: string;
  description?: string;
  confirmButtonText?: string;
  cancelButtonText?: string;
}>(), {
  title: 'Confirmar Eliminación',
  description: '¿Está seguro de que desea eliminar este elemento?',
  confirmButtonText: 'Eliminar',
  cancelButtonText: 'Cancelar'
});

const emit = defineEmits<{
  (e: 'closeModal', open: boolean): void;
  (e: 'deleteItem', itemId: number | string): void;
}>();
</script>

<style scoped></style>