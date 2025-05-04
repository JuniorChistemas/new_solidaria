<template>
    <Head title="Precios Productos"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between items-center mb-4 px-6 mt-4">
                    <ToolsProduct @import-success="loadingProductsprice" />
                    <FilterProduct @search="searchProduct" />
                </div>
                <TableProductprice
                    :product-list="principal.productpriceList"
                    :product-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdProductprice"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditProductprice
                    :productprice-data="principal.productData"
                    :modal="principal.statusModal.update"
                    :product="principal.productList"
                    @close-modal="closeModel"
                    @update-product="emitUpdateProduct"
                />
                <DeleteProduct
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idProductprice"
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
import { useProductprice } from '@/composables/useProductprice';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import DeleteProduct from '../../../components/delete.vue';
import FilterProduct from '../../../components/filter.vue';
import EditProductprice from './components/editProduct_price.vue';
import TableProductprice from './components/tableProduct_price.vue';
import { ProductpriceRequestUpdate } from './interface/Product_price';

const { principal, loadingProductsprice, getProductpriceById, updateProduct, deleteProduct } = useProductprice();

onMounted(() => {
    loadingProductsprice();
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Precio productos',
        href: '/panel/product_prices',
    },
];

const handlePageChange = (page: number) => {
    loadingProductsprice(page);
};

const getIdProductprice = (id: number) => {
    getProductpriceById(id);
};

const closeModel = (open: boolean) => {
    principal.statusModal.update = open;
};
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

const emitUpdateProduct = (productprice: ProductpriceRequestUpdate, id: number) => {
    updateProduct(id, productprice);
};

const openDeleteModal = (id: number) => {
    principal.statusModal.delete = true;
    principal.idProductprice = id;
};

const emitDeleteProduct = (id: number | string) => {
    deleteProduct(Number(id));
};
const searchProduct = (text: string) => {
    loadingProductsprice(1, text);
};
</script>
<style scoped></style>
