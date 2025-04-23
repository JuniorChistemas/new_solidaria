<template>
    <Head title="Movimientos"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterMovement @search="searchMovement" />
                <TableMovement
                    :movement-list="principal.movementList"
                    :movement-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdMovement"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditMovement
                    :movement-data="principal.movementData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-movement="emitUpdateMovement"
                />
                <DeleteMovement
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idMovement"
                    title="Eliminar Movimiento"
                    description="¿Está seguro de que desea eliminar este movimiento?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteMovement"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import DeleteMovement from '@/components/delete.vue';
import FilterMovement from '@/components/filter.vue';
import { useMovement } from '@/composables/useMovement';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditMovement from './components/editMovement.vue';
import TableMovement from './components/tableMovement.vue';
import { MovementUpdateRequest } from './interface/Movement';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear movimiento',
        href: '/panel/movements/create',
    },
    {
        title: 'Movimientos',
        href: '/panel/movements',
    },
];

onMounted(() => {
    loadingMovements();
});

const { principal, loadingMovements, getMovementById, updateMovement, deleteMovement } = useMovement();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingMovements(page);
};

// get movement by id for edit
const getIdMovement = (id: number) => {
    getMovementById(id);
};

// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};

// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update movement
const emitUpdateMovement = (movement: MovementUpdateRequest, id_movement: number) => {
    updateMovement(id_movement, movement);
};

// delete movement
const openDeleteModal = (movementId: number) => {
    principal.statusModal.delete = true;
    principal.idMovement = movementId;
    console.log('Eliminar movimiento con ID:', movementId);
};

// delete movement
const emitDeleteMovement = (movementId: number | string) => {
    deleteMovement(Number(movementId));
};

// search movement
const searchMovement = (text: string) => {
    loadingMovements(1, text);
};
</script>

<style lang="css" scoped></style>