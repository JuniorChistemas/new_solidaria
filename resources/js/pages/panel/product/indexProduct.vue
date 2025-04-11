<template>
    <Head title="Productos"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between items-center mb-4 px-6 mt-4">
                    <ToolsProduct @import-success="loadingProducts" />
                    <FilterProduct @search="searchProduct" />
                </div>
                <TableProduct
                    :product-list="principal.productList"
                    :product-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdProduct"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditProduct
                    :product-data="principal.productData"
                    :modal="principal.statusModal.update"
                    :laboratory="principal.laboratoryList"
                    :category="principal.categoryList"
                    @close-modal="closeModel"
                    @update-product="emitUpdateProduct"
                />
                <DeleteProduct
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idProduct"
                    title="Eliminar Producto"
                    description="¿Está seguro de que desea eliminar este producto?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteProduct"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import { useProduct } from '@/composables/useProduct';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import DeleteProduct from '../../../components/delete.vue';
import FilterProduct from '../../../components/filter.vue';
import EditProduct from './components/editProduct.vue';
import TableProduct from './components/tableProduct.vue';
import { ProductRequestUpdate } from './interface/Product';
import ToolsProduct from './components/toolsProduct.vue';

const { principal, loadingProducts, getProductById, updateProduct, deleteProduct } = useProduct();

onMounted(() => {
    loadingProducts();
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Producto',
        href: '/panel/products/create',
    },
    {
        title: 'Productos',
        href: '/panel/products',
    },
];

const handlePageChange = (page: number) => {
    loadingProducts(page);
};

const getIdProduct = (id: number) => {
    getProductById(id);
};

const closeModel = (open: boolean) => {
    principal.statusModal.update = open;
};
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

const emitUpdateProduct = (product: ProductRequestUpdate, id: number) => {
    updateProduct(id, product);
};

const openDeleteModal = (id: number) => {
    principal.statusModal.delete = true;
    principal.idProduct = id;
};

const emitDeleteProduct = (id: number | string) => {
    deleteProduct(Number(id));
};
const searchProduct = (text: string) => {
    loadingProducts(1, text);
};
</script>
<style scoped></style>
