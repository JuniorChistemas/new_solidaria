<template>
    <Head title="role"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterRole @search="searchRole" />
                <TableRole
                    :role-list="principal.roleList"
                    :role-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdRole"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditRole
                    :role-data="principal.roleData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-role="emitUpdateRole"
                />
                <DeleteRole
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idRole"
                    title="Eliminar Rol"
                    description="¿Está seguro de que desea eliminar este rol?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteRole"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import DeleteRole from '@/components/delete.vue';
import FilterRole from '@/components/filter.vue';
import { useRole } from '@/composables/useRole';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditRole from './components/editRole.vue';
import TableRole from './components/tableRole.vue';
import { RoleUpdateRequest } from './interface/Role';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Rol',
        href: '/panel/roles/create',
    },
    /*{
        title: 'Exportar a Excel',
        href: '/panel/reports/export-excel-roles',
        download: true,
    },
    {
        title: 'Exportar a PDF',
        href: '/panel/reports/export-pdf-roles',
        download: true,
    },*/
    {
        title: 'Roles',
        href: '/panel/roles',
    },
];

onMounted(() => {
    console.log('onMounted: Cargando roles...');
    loadingRoles();
});

const { principal, loadingRoles, getRoleById, updateRole, deleteRole } = useRole();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingRoles(page);
};
// get role by id for edit
const getIdRole = (id: number) => {
    getRoleById(id);
};
// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};
// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update role
const emitUpdateRole = (role: RoleUpdateRequest, id_role: number) => {
    updateRole(id_role, role);
};

// delete role
const openDeleteModal = (roleId: number) => {
    principal.statusModal.delete = true;
    principal.idRole = roleId;
    console.log('Eliminar rol con ID:', roleId);
};
// delete role
const emitDeleteRole = (roleId: number | string) => {
    deleteRole(Number(roleId));
};
// search role
const searchRole = (text: string) => {
    loadingRoles(1, text);
};

</script>
<style lang="css" scoped></style>