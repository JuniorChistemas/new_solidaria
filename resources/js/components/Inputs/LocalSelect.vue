<template>
    <Select @update:model-value="(id) => id !== null && emit('local_id', Number(id))" :defaultValue="0" class="w-[180px]">
        <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Seleccionar el local" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>Locales</SelectLabel>
                <template v-for="local in locals" :key="local.id">
                    <SelectItem :value="local.id">{{ local.name }}</SelectItem>
                </template>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>
<script setup lang="ts">
import { useLocal } from '@/composables/useLocal';
import { onMounted } from 'vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '../ui/select';

const { locals, getLocalList } = useLocal();

const emit = defineEmits<{
    (e: 'local_id', id: number): void;
}>();

onMounted(() => {
    getLocalList();
});
</script>
<style scoped></style>
