<template>
    <!-- Estado de carga inicial -->
    <div v-if="isLoading" class="flex items-center space-x-2 py-2">
      <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
      <span class="text-sm text-muted-foreground">Cargando locales...</span>
    </div>
  
    <!-- Mensaje de error -->
    <div v-else-if="error" class="py-2 text-sm text-red-500">Error al cargar locales. Intente nuevamente.</div>
  
    <!-- Combobox con altura controlada -->
    <Combobox v-else by="id" v-model="selectedLocal">
      <ComboboxAnchor>
        <div class="relative w-full items-center">
          <ComboboxInput
            class="pl-9"
            :display-value="(val) => val?.name ?? ''"
            :model-value="searchText"
            placeholder="Seleccionar local..."
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
        <ComboboxEmpty>No se encontró ningún local.</ComboboxEmpty>
        <ComboboxGroup>
          <ComboboxItem
            v-for="local in filteredLocals"
            :key="local.id"
            :value="local"
            @select="onSelect(local)"
            class="px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
          >
            {{ local.name }}
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
  import { localServices } from '@/services/localServices';
  import { LocalResponse } from '@/pages/panel/local/interface/Local';
  
  const emit = defineEmits<{
    (e: 'select', local_id: number): void;
  }>();
  
  // Estado
  const locals = ref<LocalResponse['locals'][]>([]);
  const searchText = ref<string>('');
  const error = ref<boolean>(false);
  const isLoading = ref<boolean>(true);
  const isSearching = ref<boolean>(false);
  const selectedLocal = ref<LocalResponse['locals'] | null>(null);
  const initialLoadDone = ref<boolean>(false);
  
  const filteredLocals = computed(() => {
    if (!searchText.value) return locals.value;
  
    return locals.value.filter((local) =>
      local.name.toLowerCase().includes(searchText.value.toLowerCase())
    );
  });
  
  const initialLoadLocals = async () => {
    if (initialLoadDone.value) return;
  
    try {
      isLoading.value = true;
      const response = await localServices.index(1, '');
      locals.value = response.locals || [];
      error.value = false;
      initialLoadDone.value = true;
    } catch (e) {
      console.error('Error al cargar locales:', e);
      error.value = true;
    } finally {
      isLoading.value = false;
    }
  };
  
  const searchLocals = async (query: string) => {
    if (!initialLoadDone.value) return;
  
    try {
      isSearching.value = true;
      const response = await localServices.index(1, query);
      locals.value = response.locals || [];
      error.value = false;
    } catch (e) {
      console.error('Error al buscar locales:', e);
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
      searchLocals(value);
    }
  }, 400);
  
  const onSelect = (local: LocalResponse['locals']) => {
    selectedLocal.value = local;
    emit('select', local.id);
  };
  
  // Expose reset method to clear selection
  const reset = () => {
    selectedLocal.value = null;
    searchText.value = ''; // Optionally clear search text
  };
  
  defineExpose({ reset });
  
  onMounted(() => {
    initialLoadLocals();
  });
  </script>
  
  <style scoped></style>