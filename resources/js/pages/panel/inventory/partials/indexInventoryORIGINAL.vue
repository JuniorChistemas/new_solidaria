<template>
    <Head title="Inventario"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterInventory @search="applyFilters" />
                <TableInventory
                    :product-list="principal.productList"
                    :product-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    :loading="principal.loading"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import FilterInventory from '@/components/filter.vue';
import { useInventory } from '@/composables/useInventory';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import TableInventory from './components/TableInventory.vue';
import { FilterParams } from '@/services/inventoryService';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/panel/inventory',
    },
];

// Almacenar los filtros activos
const activeFilters = ref<FilterParams>({
    page: 1,
    per_page: 10,
    nombre: '',
    estadoStock: '3',
    localId: null,
    laboratorioId: null,
    categoriaId: null
});

onMounted(() => {
    // Cargar con los filtros por defecto
    loadingProducts(1, activeFilters.value);
});

const { principal, loadingProducts, getProductById } = useInventory();

// Manejar cambio de página
const handlePageChange = (page: number) => {
    activeFilters.value.page = page;
    loadingProducts(page, activeFilters.value);
};

// Aplicar filtros
const applyFilters = (filters: FilterParams) => {
    activeFilters.value = { ...filters };
    loadingProducts(1, activeFilters.value);
};

// Obtener producto por id para edición
const getIdProduct = (id: number) => {
    getProductById(id);
};
</script>

<style lang="css" scoped></style>