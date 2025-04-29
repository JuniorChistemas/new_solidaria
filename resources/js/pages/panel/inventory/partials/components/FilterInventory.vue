<template>
    <div class="flex flex-wrap gap-4 mb-4 items-end p-4">
        <div class="w-full sm:w-72">
            <label class="text-sm font-medium mb-1 block">Categoría</label>
            <CategoryCombobox @select="handleCategorySelect" />
        </div>
        <div class="w-full sm:w-72">
            <label class="text-sm font-medium mb-1 block">Laboratorio</label>
            <LaboratoryCombobox @select="handleLaboratorySelect" />
        </div>
        <div class="w-full sm:w-72">
            <label class="text-sm font-medium mb-1 block">Local</label>
            <LocalCombobox @select="handleLocalSelect" />
        </div>
        <div class="w-full sm:w-72">
            <label class="text-sm font-medium mb-1 block">Nombre</label>
            <input
                v-model="filters.nombre"
                type="text"
                class="w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Buscar por nombre..."
            />
        </div>
        <div class="w-full sm:w-auto">
            <Button @click="applyFilters" class="bg-primary text-white px-4 py-2">
                Filtrar
            </Button>
        </div>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import CategoryCombobox from '@/components/Inputs/CategoryCombobox.vue';
import LaboratoryCombobox from '@/components/Inputs/LaboratoryCombobox.vue';
import LocalCombobox from '@/components/Inputs/LocalCombobox.vue';
import { reactive } from 'vue';

const emit = defineEmits<{
    (e: 'filter', filters: {
        page?: number;
        per_page?: number;
        localId?: number;
        laboratorioId?: number;
        categoriaId?: number;
        nombre?: string;
    }): void;
}>();

// Estado para los filtros
const filters = reactive<{
    categoriaId?: number;
    laboratorioId?: number;
    localId?: number;
    nombre: string;
    page: number;
    per_page: number;
}>({
    categoriaId: undefined,
    laboratorioId: undefined,
    localId: undefined,
    nombre: '',
    page: 1,
    per_page: 10,
});

// Handlers para los comboboxes
const handleCategorySelect = (category_id: number) => {
    filters.categoriaId = category_id;
};

const handleLaboratorySelect = (laboratory_id: number) => {
    filters.laboratorioId = laboratory_id;
};

const handleLocalSelect = (local_id: number) => {
    filters.localId = local_id;
};

// Aplicar filtros al hacer clic en el botón
const applyFilters = () => {
    emit('filter', { ...filters });
};
</script>

<style scoped></style>