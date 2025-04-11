<template>
    <Head title="local"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterLocal @search="searchLocal" />
                <TableLocal
                    :local-list="principal.localList"
                    :local-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdLocal"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditLocal
                    :local-data="principal.localData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-local="emitUpdateLocal"
                />
                <DeleteLocal
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idLocal"
                    title="Eliminar Local"
                    description="¿Está seguro de que desea eliminar este local?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteLocal"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import DeleteLocal from '@/components/delete.vue';
import FilterLocal from '@/components/filter.vue';
import { useLocal } from '@/composables/useLocal';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import EditLocal from './components/editLocal.vue';
import TableLocal from './components/tableLocal.vue';
import { LocalUpdateRequest } from './interface/Local';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Local',
        href: '/panel/locals/create',
    },
    {
        title: 'Locales',
        href: '/panel/locals',
    },
];

onMounted(() => {
    loadingLocals();
});

const { principal, loadingLocals, getLocalById, updateLocal, deleteLocal } = useLocal();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingLocals(page);
};
// get locals by id for edit
const getIdLocal = (id: number) => {
    getLocalById(id);
};
// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};
// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update local
const emitUpdateLocal = (local: LocalUpdateRequest, id_local: number) => {
    updateLocal(id_local, local);
};

// delete local
const openDeleteModal = (localId: number) => {
    principal.statusModal.delete = true;
    principal.idLocal = localId;
    console.log('Eliminar Local con ID:', localId);
};
// delete local
const emitDeleteLocal = (localId: number | string) => {
    deleteLocal(Number(localId));
};
// search local
const searchLocal = (text: string) => {
    loadingLocals(1, text);
};
</script>
<style lang="css" scoped></style>
