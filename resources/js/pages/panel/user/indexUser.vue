<template>
    <Head title="Usuarios"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterUser @search="searchUser" />
                <TableUser
                    :user-list="principal.userList"
                    :user-paginate="principal.paginacion"
                    :loading="principal.loading"
                    @page-change="handlePageChange"
                    @open-modal="getIdUpdate"
                    @open-modal-delete="getIdDelete"
                />
                <EditUser
                    v-if="user_show"
                    :status-modal="principal.statusModalUpdate"
                    :user_data="user_show"
                    @close-modal="closeModalUpdate"
                    @update-user="dataUpdateUser"
                />
                <DeleteUser
                    :modal="principal.statusModalDelete"
                    :item-id="principal.user_id_delete"
                    title="Eliminar usuario"
                    description="¿Está seguro de que desea eliminar este usuario?"
                    @close-modal="clouseModalDelete"
                    @delete-item="emitDeletePayment"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import DeleteUser from '@/components/delete.vue';
import FilterUser from '@/components/filter.vue';
import { useUser } from '@/composables/useUser';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditUser from './components/editUser.vue';
import TableUser from './components/tableUser.vue';
import { UserUpdateRequest } from './interface/User';

const { principal, user_show, loadingUser, showUser, updateUser, deleteUser } = useUser();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nuevo Usuario',
        href: '/panel/users/create',
    },
    {
        title: 'Usuarios',
        href: '/panel/users',
    },
];

const handlePageChange = (page: number) => {
    loadingUser(page);
};

const closeModalUpdate = () => {
    principal.statusModalUpdate = false;
};

const getIdUpdate = (id: number) => {
    console.log(id);
    showUser(id);
};

const getIdDelete = (id: number) => {
    principal.statusModalDelete = true;
    principal.user_id_delete = id;
    console.log('eliminar' + id);
};

const emitDeletePayment = (id: number | string) => {
    // principal.statusModalDelete = false;
    console.log('emitDeletePayment', id);
    // deletePayment(Number(id));
    deleteUser(Number(id));
};

const clouseModalDelete = () => {
    principal.statusModalDelete = false;
};

// get data from editPayment
const dataUpdateUser = (data: UserUpdateRequest, id: number) => {
    console.log('dataUpdatePayment', data);
    updateUser(id, data);
};

const searchUser = (text: string) => {
    loadingUser(1, text);
};

onMounted(() => {
    loadingUser();
});
</script>
<style scoped></style>
