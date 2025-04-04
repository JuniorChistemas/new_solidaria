<template>
    <Head title="category"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterCategory @search="searchCategory" />
                <TableCategory
                    :category-list="principal.categoryList"
                    :category-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdCategory"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditCategory
                    :category-data="principal.categoryData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-category="emitUpdateCategory"
                />
                <DeleteCategory
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idCategory"
                    title="Eliminar Categoría"
                    description="¿Está seguro de que desea eliminar esta categoría?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteCategory"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { CategoryUpdateRequest } from './interface/Category';
import { useCategory } from '@/composables/useCategory';
import { BreadcrumbItem } from '@/types';
import FilterCategory from '@/components/filter.vue';
import TableCategory from './components/tableCategory.vue';
import EditCategory from './components/editCategory.vue';
import DeleteCategory from '@/components/delete.vue';

const breadcrumbs: BreadcrumbItem[] = [
{
        title: 'Crear categoría',
        href: '/panel/categories/create',
    },
    /*{
        title: 'Exportar a Excel',
        href: '/panel/reports/export-excel-categories',
        download: true,
    },
    {
        title: 'Exportar a PDF',
        href: '/panel/reports/export-pdf-categories',
        download: true,
    },*/
    {
        title: 'Categorías',
        href: '/panel/categories',
    },
];

onMounted(() => {
    loadingCategories();
});

const {principal, loadingCategories, getCategoryById, updateCategory, deleteCategory} = useCategory();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingCategories(page);
};
// get category by id for edit
const getIdCategory = (id: number) => {
    getCategoryById(id);
};
// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};
// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update category
const emitUpdateCategory = (category: CategoryUpdateRequest, id_category: number) => {
    updateCategory(id_category, category);
};

// delete category
const openDeleteModal = (categoryId: number) => {
    principal.statusModal.delete = true;
    principal.idCategory = categoryId;
    console.log('Eliminar categoría con ID:', categoryId);
};
// delete category
const emitDeleteCategory = (categoryId: number | string) => {
    deleteCategory(Number(categoryId));
};
// search category
const searchCategory = (text: string) => {
    loadingCategories(1, text);
};
</script>
<style lang="css" scoped></style>