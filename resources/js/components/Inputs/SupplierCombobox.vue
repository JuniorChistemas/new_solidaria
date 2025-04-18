<template>
    <!-- Estado de carga inicial -->
    <div v-if="isLoading" class="flex items-center space-x-2 py-2">
        <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
        <span class="text-sm text-muted-foreground">Cargando proveedores...</span>
    </div>
    
    <!-- Mensaje de error -->
    <div v-else-if="error" class="py-2 text-sm text-red-500">Error al cargar proveedores. Intente nuevamente.</div>
    
    <!-- Combobox con altura controlada -->
    <Combobox v-else by="id" v-model="selectedSupplier">
        <ComboboxAnchor>
            <div class="relative w-full items-center">
                <ComboboxInput
                    class="pl-9"
                    :display-value="(val) => val?.name ?? ''"
                    :model-value="searchText"
                    placeholder="Seleccionar proveedor..."
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
            <ComboboxEmpty>No se encontró ningún proveedor.</ComboboxEmpty>
            <ComboboxGroup>
                <ComboboxItem 
                    v-for="supplier in filteredSuppliers" 
                    :key="supplier.id" 
                    :value="supplier" 
                    @select="onSelect(supplier)"
                    class="px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                >
                    {{ supplier.name }}
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
import { onMounted, ref, computed } from 'vue';
import debounce from 'debounce';
import { SupplierServices } from '@/services/supplierServices';
import { SupplierResource } from '@/pages/panel/supplier/interface/Supplier';

const emit = defineEmits<{
    (e: 'select', supplier_id: number): void;
}>();

// Estado
const suppliers = ref<SupplierResource[]>([]);
const searchText = ref<string>('');
const error = ref<boolean>(false);
const isLoading = ref<boolean>(true);
const isSearching = ref<boolean>(false);
const selectedSupplier = ref<SupplierResource | null>(null);
const initialLoadDone = ref<boolean>(false);


const filteredSuppliers = computed(() => {
    if (!searchText.value) return suppliers.value;
    
    return suppliers.value.filter(supplier => 
        supplier.name.toLowerCase().includes(searchText.value.toLowerCase())
    );
});


const initialLoadSuppliers = async () => {
    if (initialLoadDone.value) return;
    
    try {
        isLoading.value = true;
        const response = await SupplierServices.getSuppliers('');
        suppliers.value = response || [];
        error.value = false;
        initialLoadDone.value = true;
    } catch (e) {
        console.error('Error al cargar proveedores:', e);
        error.value = true;
    } finally {
        isLoading.value = false;
    }
};


const searchSuppliers = async (query: string) => {
    if (!initialLoadDone.value) return;
    
    try {
        isSearching.value = true;
        const response = await SupplierServices.getSuppliers(query);
        suppliers.value = response || [];
        error.value = false;
    } catch (e) {
        console.error('Error al buscar proveedores:', e);
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
        searchSuppliers(value);
    }
}, 400);


const onSelect = (supplier: SupplierResource) => {
    selectedSupplier.value = supplier;
    emit('select', supplier.id);
};


onMounted(() => {
    initialLoadSuppliers();
});
</script>

<style scoped></style>