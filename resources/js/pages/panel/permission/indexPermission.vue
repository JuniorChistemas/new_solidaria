<template>
    <Head title="permission"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterPermission @search="searchPermission" />
                <TablePermission
                    :permission-list="principal.permissionList"
                    :permission-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdPermission"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditPermission
                    :permission-data="principal.permissionData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-permission="emitUpdatePermission"
                />
                <DeletePermission
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idPermission"
                    title="Eliminar Permiso"
                    description="¿Está seguro de que desea eliminar este permiso?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeletePermission"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import DeletePermission from '@/components/delete.vue';
import FilterPermission from '@/components/filter.vue';
import { usePermission } from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditPermission from './components/editPermission.vue';
import TablePermission from './components/tablePermission.vue';
import { PermissionUpdateRequest } from './interface/Permission';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear permiso',
        href: '/panel/permissions/create',
    },
    {
        title: 'Permisos',
        href: '/panel/permissions',
    },
];

onMounted(() => {
    loadingPermissions();
});

const { principal, loadingPermissions, getPermissionById, updatePermission, deletePermission } = usePermission();

// get pagination
const handlePageChange = (page: number) => {
    loadingPermissions(page);
};

// get permission by id for edit
const getIdPermission = (id: number) => {
    getPermissionById(id);
};

// close edit modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};

// close delete modal
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update permission
const emitUpdatePermission = (permission: PermissionUpdateRequest, id_permission: number) => {
    updatePermission(id_permission, permission);
};

// open delete confirmation modal
const openDeleteModal = (permissionId: number) => {
    principal.statusModal.delete = true;
    principal.idPermission = permissionId;
};

// delete permission
const emitDeletePermission = (permissionId: number | string) => {
    deletePermission(Number(permissionId));
};

// search permission
const searchPermission = (text: string) => {
    loadingPermissions(1, text);
};
</script>

<style scoped></style>
