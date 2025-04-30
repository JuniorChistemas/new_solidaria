<template>
  <div class="p-4 rounded-lg">
    <div class="flex flex-wrap gap-4 mb-4 container-table mx-auto">
      <!-- Filtro por nombre -->
      <div class="w-full sm:w-64">
        <label class="text-sm font-medium mb-1 block">Nombre de Producto</label>
        <input
          type="text"
          v-model="filters.nombre"
          placeholder="Buscar por nombre..."
          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
        />
      </div>

      <!-- Filtros con comboboxes -->
      <div class="w-full sm:w-64">
        <label class="text-sm font-medium mb-1 block">Laboratorio</label>
        <LaboratoryCombobox ref="laboratoryCombobox" @select="handleLaboratorySelect" />
      </div>
      <div class="w-full sm:w-64">
        <label class="text-sm font-medium mb-1 block">Categoría</label>
        <CategoryCombobox ref="categoryCombobox" @select="handleCategorySelect" />
      </div>
      <div class="w-full sm:w-64">
        <label class="text-sm font-medium mb-1 block">Local</label>
        <LocalCombobox ref="localCombobox" @select="handleLocalSelect" />
      </div>
    </div>

    <!-- Radio buttons para estado de stock -->
    <div class="mb-4 container-table mx-auto">
      <label class="text-sm font-medium mb-2 block">Estado de Stock</label>
      <div class="flex flex-wrap gap-4">
        <div class="flex items-center">
          <input
            type="radio"
            id="todos"
            name="estadoStock"
            value="3"
            v-model="filters.estadoStock"
            class="mr-2"
          />
          <label for="todos" class="text-sm">Todos</label>
        </div>
        <div class="flex items-center">
          <input
            type="radio"
            id="conStock"
            name="estadoStock"
            value="1"
            v-model="filters.estadoStock"
            class="mr-2"
          />
          <label for="conStock" class="text-sm">Con Stock</label>
        </div>
        <div class="flex items-center">
          <input
            type="radio"
            id="sinStock"
            name="estadoStock"
            value="0"
            v-model="filters.estadoStock"
            class="mr-2"
          />
          <label for="sinStock" class="text-sm">Sin Stock</label>
        </div>
      </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-wrap gap-3 container-table mx-auto">
      <button
        @click="applyFilters"
        class="px-4 py-2 bg-green-600 dark:bg-blue-600 text-white rounded-md hover:bg-green-700 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-blue-500 focus:ring-offset-2"
      >
        <span class="flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 mr-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
            />
          </svg>
          Filtrar
        </span>
      </button>
      <button
        @click="clearFilters"
        class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
      >
        <span class="flex items-center">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 mr-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
          Limpiar
        </span>
      </button>
    </div>
  </div>
</template>
  
<script setup lang="ts">
import { ref, reactive } from 'vue';
import CategoryCombobox from '@/components/Inputs/CategoryCombobox.vue';
import LaboratoryCombobox from '@/components/Inputs/LaboratoryCombobox.vue';
import LocalCombobox from '@/components/Inputs/LocalCombobox.vue';

const emit = defineEmits<{
  (e: 'search', filters: FilterParams): void;
}>();

interface FilterParams {
  page: number;
  per_page: number;
  nombre: string;
  estadoStock: string;
  localId: number | null;
  laboratorioId: number | null;
  categoriaId: number | null;
}

const filters = reactive<FilterParams>({
  page: 1,
  per_page: 10,
  nombre: '',
  estadoStock: '3', // Por defecto, mostrar todos (3)
  localId: null,
  laboratorioId: null,
  categoriaId: null,
});

// References to combobox components
const laboratoryCombobox = ref<InstanceType<typeof LaboratoryCombobox> | null>(null);
const categoryCombobox = ref<InstanceType<typeof CategoryCombobox> | null>(null);
const localCombobox = ref<InstanceType<typeof LocalCombobox> | null>(null);

const handleCategorySelect = (categoryId: number) => {
  filters.categoriaId = categoryId;
};

const handleLaboratorySelect = (laboratoryId: number) => {
  filters.laboratorioId = laboratoryId;
};

const handleLocalSelect = (localId: number) => {
  filters.localId = localId;
};

const applyFilters = () => {
  filters.page = 1; // Reiniciar a la primera página al aplicar filtros
  emit('search', filters);
};

const clearFilters = () => {
  // Restablecer todos los filtros a sus valores predeterminados
  filters.nombre = '';
  filters.estadoStock = '3';
  filters.localId = null;
  filters.laboratorioId = null;
  filters.categoriaId = null;

  // Reset combobox selections
  laboratoryCombobox.value?.reset();
  categoryCombobox.value?.reset();
  localCombobox.value?.reset();

  // Aplicar los filtros restablecidos
  applyFilters();
};
</script>