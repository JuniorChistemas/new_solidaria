<template>
    <Select @update:model-value="(id) => id !== null && emit('role_name', String(id))" :defaultValue="0" class="w-[180px]">
        <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Seleccionar el rol" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel>Roles</SelectLabel>
                <template v-for="role in roles" :key="role.id">
                    <SelectItem :value="role.name">{{ role.name }}</SelectItem>
                </template>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>
<script setup lang="ts">
import { useRole } from '@/composables/useRole';
import { onMounted } from 'vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '../ui/select';

const { roles, getRoles } = useRole();

const emit = defineEmits<{
    (e: 'role_name', name: string): void;
}>();

onMounted(() => {
    getRoles();
});
</script>
<style scoped></style>
