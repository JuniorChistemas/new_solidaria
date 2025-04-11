<template>
    <Head title="Tipos de Cliente"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterClientType @search="searchClientType" />
                <TableClientType
                    :client-type-list="principal.clientTypeList"
                    :client-type-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdClientType"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditClientType
                    :client-type-data="principal.clientTypeData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-client-type="emitUpdateClientType"
                />
                <DeleteClientType
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idClientType"
                    title="Eliminar Tipo de Cliente"
                    description="¿Está seguro de que desea eliminar este tipo de cliente?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteClientType"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import DeleteClientType from '@/components/delete.vue';
import FilterClientType from '@/components/filter.vue';
import { useClientType } from '@/composables/useClientType';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditClientType from './components/editClientType.vue';
import TableClientType from './components/tableClientType.vue';
import { ClientTypeUpdateRequest } from './interface/ClientType';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear tipo de cliente',
        href: '/panel/clientTypes/create',
    },
    {
        title: 'Tipos de Cliente',
        href: '/panel/clientTypes',
    },
];

onMounted(() => {
    loadingClientTypes();
});

const { principal, loadingClientTypes, getClientTypeById, updateClientType, deleteClientType } = useClientType();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingClientTypes(page);
};

// get client type by id for edit
const getIdClientType = (id: number) => {
    getClientTypeById(id);
};

// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};

// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update client type
const emitUpdateClientType = (clientType: ClientTypeUpdateRequest, id_clientType: number) => {
    updateClientType(id_clientType, clientType);
};

// delete client type 
const openDeleteModal = (clientTypeId: number) => {
    principal.statusModal.delete = true;
    principal.idClientType = clientTypeId;
    console.log('Eliminar tipo de cliente con ID:', clientTypeId);
};

// delete client type
const emitDeleteClientType = (clientTypeId: number | string) => {
    deleteClientType(Number(clientTypeId));
};

// search client type
const searchClientType = (text: string) => {
    loadingClientTypes(1, text);
};
</script>

<style lang="css" scoped></style>