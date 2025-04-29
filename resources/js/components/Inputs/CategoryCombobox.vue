<template>
    <!-- Estado de carga inicial -->
    <div v-if="isLoading" class="flex items-center space-x-2 py-2">
      <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
      <span class="text-sm text-muted-foreground">Cargando categorías...</span>
    </div>
  
    <!-- Mensaje de error -->
    <div v-else-if="error" class="py-2 text-sm text-red-500">Error al cargar categorías. Intente nuevamente.</div>
  
    <!-- Combobox con altura controlada -->
    <Combobox v-else by="id" v-model="selectedCategory">
      <ComboboxAnchor>
        <div class="relative w-full items-center">
          <ComboboxInput
            class="pl-9"
            :display-value="(val) => val?.name ?? ''"
            :model-value="searchText"
            placeholder="Seleccionar categoría..."
            @update:model-value="handleSearchInput"
          />
          <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
            <Search class="size-4 text-muted-foreground" />
          </span>
          <!-- Indicador de búsqueda -->
          <span v-if="isSearching" class="absolute inset-y-0 end-0 flex items-center justify-center px-3">
            <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
          </span>
        </div>
      </ComboboxAnchor>
  
      <!-- Contenedor con scroll -->
      <ComboboxList class="max-h-60 overflow-y-auto">
        <ComboboxEmpty>No se encontró ninguna categoría.</ComboboxEmpty>
        <ComboboxGroup>
          <ComboboxItem
            v-for="category in filteredCategories"
            :key="category.id"
            :value="category"
            @select="onSelect(category)"
            class="px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
          >
            {{ category.name }}
            <ComboboxItemIndicator>
              <Check class="ml-auto h-4 w-4" />
            </ComboboxItemIndicator>
          </ComboboxItem>
        </ComboboxGroup>
      </ComboboxList>
    </Combobox>
  </template>
  
  <script setup lang="ts">
  import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
  } from '@/components/ui/combobox';
  import { Check, Search } from 'lucide-vue-next';
  import { onMounted, ref, computed, defineExpose } from 'vue';
  import debounce from 'debounce';
  import { CategoryServices } from '@/services/categoryServices';
  import { CategoryResponse } from '@/pages/panel/category/interface/Category';
  
  const emit = defineEmits<{
    (e: 'select', category_id: number): void;
  }>();
  
  // Estado
  const categories = ref<CategoryResponse['categories'][]>([]);
  const searchText = ref<string>('');
  const error = ref<boolean>(false);
  const isLoading = ref<boolean>(true);
  const isSearching = ref<boolean>(false);
  const selectedCategory = ref<CategoryResponse['categories'] | null>(null);
  const initialLoadDone = ref<boolean>(false);
  
  const filteredCategories = computed(() => {
    if (!searchText.value) return categories.value;
  
    return categories.value.filter((category) =>
      category.name.toLowerCase().includes(searchText.value.toLowerCase())
    );
  });
  
  const initialLoadCategories = async () => {
    if (initialLoadDone.value) return;
  
    try {
      isLoading.value = true;
      const response = await CategoryServices.index(1, '');
      categories.value = response.categories || [];
      error.value = false;
      initialLoadDone.value = true;
    } catch (e) {
      console.error('Error al cargar categorías:', e);
      error.value = true;
    } finally {
      isLoading.value = false;
    }
  };
  
  const searchCategories = async (query: string) => {
    if (!initialLoadDone.value) return;
  
    try {
      isSearching.value = true;
      const response = await CategoryServices.index(1, query);
      categories.value = response.categories || [];
      error.value = false;
    } catch (e) {
      console.error('Error al buscar categorías:', e);
    } finally {
      isSearching.value = false;
    }
  };
  
  const handleSearchInput = (value: string) => {
    searchText.value = value;
    if (initialLoadDone.value) {
      debouncedSearch(value);
    }
  };
  
  const debouncedSearch = debounce((value: string) => {
    if (value.length >= 3 || value === '') {
      searchCategories(value);
    }
  }, 400);
  
  const onSelect = (category: CategoryResponse['categories']) => {
    selectedCategory.value = category;
    emit('select', category.id);
  };
  
  // Expose reset method to clear selection
  const reset = () => {
    selectedCategory.value = null;
    searchText.value = ''; // Optionally clear search text
  };
  
  defineExpose({ reset });
  
  onMounted(() => {
    initialLoadCategories();
  });
  </script>
  
  <style scoped></style>