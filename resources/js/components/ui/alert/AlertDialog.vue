<!-- components/ui/alert-dialog/AlertDialog.vue -->
<template>
    <DialogRoot v-bind="forwarded">
      <slot />
    </DialogRoot>
  </template>
  
  <script setup lang="ts">
  import { DialogRoot } from 'radix-vue'
  import { useForwardPropsEmits } from 'radix-vue'
  
  //const forwarded = useForwardPropsEmits()
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogContent.vue -->
  <template>
    <DialogPortal>
      <DialogOverlay 
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0" 
      />
      <DialogContent 
        :class="cn(
          'fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] md:w-full',
          $attrs.class ?? ''
        )"
      >
        <slot />
      </DialogContent>
    </DialogPortal>
  </template>
  
  <script setup lang="ts">
  import { DialogContent, DialogPortal, DialogOverlay } from 'radix-vue'
  import { cn } from '@/lib/utils'
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogHeader.vue -->
  <template>
    <div :class="cn('flex flex-col space-y-2 text-center sm:text-left', $attrs.class)">
      <slot />
    </div>
  </template>
  
  <script setup lang="ts">
  import { cn } from '@/lib/utils'
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogFooter.vue -->
  <template>
    <div :class="cn(
      'flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2',
      $attrs.class
    )">
      <slot />
    </div>
  </template>
  
  <script setup lang="ts">
  import { cn } from '@/lib/utils'
  </script>
  
  <!-- Individual component files for other parts -->
  <!-- components/ui/alert-dialog/AlertDialogTitle.vue -->
  <template>
    <DialogTitle 
      :class="cn(
        'text-lg font-semibold text-foreground',
        $attrs.class
      )"
    >
      <slot />
    </DialogTitle>
  </template>
  
  <script setup lang="ts">
  import { DialogTitle } from 'radix-vue'
  import { cn } from '@/lib/utils'
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogDescription.vue -->
  <template>
    <DialogDescription 
      :class="cn(
        'text-sm text-muted-foreground',
        $attrs.class
      )"
    >
      <slot />
    </DialogDescription>
  </template>
  
  <script setup lang="ts">
  import { DialogDescription } from 'radix-vue'
  import { cn } from '@/lib/utils'
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogCancel.vue -->
  <template>
    <Button 
      variant="outline" 
      @click="$emit('click')"
    >
      <slot>Cancelar</slot>
    </Button>
  </template>
  
  <script setup lang="ts">
  import Button from '../button/Button.vue'
  </script>
  
  <!-- components/ui/alert-dialog/AlertDialogAction.vue -->
  <template>
    <Button 
      @click="$emit('click')"
    >
      <slot>Confirmar</slot>
    </Button>
  </template>
  
  <script setup lang="ts">
  import Button from '../button/Button.vue'
  </script>
  
  <!-- components/ui/alert-dialog/index.ts -->
  export { default as AlertDialog } from './AlertDialog.vue'
  export { default as AlertDialogContent } from './AlertDialogContent.vue'
  export { default as AlertDialogHeader } from './AlertDialogHeader.vue'
  export { default as AlertDialogFooter } from './AlertDialogFooter.vue'
  export { default as AlertDialogTitle } from './AlertDialogTitle.vue'
  export { default as AlertDialogDescription } from './AlertDialogDescription.vue'
  export { default as AlertDialogCancel } from './AlertDialogCancel.vue'
  export { default as AlertDialogAction } from './AlertDialogAction.vue'