<template>
    <Head title="Inventario"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterInventory @search="searchInventory" />
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
import { onMounted } from 'vue';
import TableInventory from './components/TableInventory.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inventario',
        href: '/panel/inventory',
    },
];

onMounted(() => {
    loadingProducts();
});

const { principal, loadingProducts, getProductById } = useInventory();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingProducts(page);
};

// get product by id for edit
const getIdProduct = (id: number) => {
    getProductById(id);
};

// search inventory
const searchInventory = (text: string) => {
    loadingProducts(1, text);
};
</script>

<style lang="css" scoped></style>