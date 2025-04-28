<template>
    <Head title="laboratory" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="flex justify-between items-center mb-4 px-6 mt-4">
                    <ToolsLaboratory @import-success="loadingLaboratories"/>
                    <FilterLaboratory @search="searchLaboratory" />
                </div>
                <TableLaboratory
                    :laboratory-list="principal.laboratoryList"
                    :laboratory-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdLaboratory"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditLaboratory
                    :laboratory-data="principal.laboratoryData"
                    :modal="principal.stateModal.update"
                    @emit-close="closeModal"
                    @update-laboratory="emitUpdateLaboratory"
                />
                <DeleteLaboratory
                    :modal="principal.stateModal.delete"
                    :itemId="principal.idLaboratory"
                    title="Eliminar Laboratorio"
                    description="¿Está seguro de que desea eliminar este laboratorio?"
                    @close-modal="closeModalDelete"
                    @delete-Item="emitDeleteLaboratory"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import DeleteLaboratory from '@/components/delete.vue';
import FilterLaboratory from '@/components/filter.vue';
import { useLaboratory } from '@/composables/useLaboratory';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditLaboratory from './components/editLaboratory.vue';
import TableLaboratory from './components/tableLaboratory.vue';
import { LaboratoryUpdateRequest } from './interface/Laboratory';
import ToolsLaboratory from './components/toolsLaboratory.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear laboratorio',
        href: '/panel/laboratories/create',
    },
    {
        title: 'Laboratorios',
        href: '/panel/laboratories',
    },
];

onMounted(() => {
    loadingLaboratories();
});

const { principal, loadingLaboratories, getLaboratoryById, updateLaboratory, deleteLaboratory } = useLaboratory();

// paginación
const handlePageChange = (page: number) => {
    console.log(page);
    loadingLaboratories(page);
};

// obtener por ID
const getIdLaboratory = (id: number) => {
    getLaboratoryById(id);
};

// cerrar modal de edición
const closeModal = (open: boolean) => {
    principal.stateModal.update = open;
};

// cerrar modal de eliminación
const closeModalDelete = (open: boolean) => {
    principal.stateModal.delete = open;
};

// actualizar laboratorio
const emitUpdateLaboratory = (laboratory: LaboratoryUpdateRequest, id_laboratory: number) => {
    updateLaboratory(id_laboratory, laboratory);
};

// abrir modal de eliminación
const openDeleteModal = (laboratoryId: number) => {
    principal.stateModal.delete = true;
    principal.idLaboratory = laboratoryId;
    console.log('Eliminar laboratorio con ID:', laboratoryId);
};

// ejecutar eliminación
const emitDeleteLaboratory = (laboratoryId: number | string) => {
    deleteLaboratory(Number(laboratoryId));
};

// buscar laboratorio
const searchLaboratory = (text: string) => {
    loadingLaboratories(1, text);
};
</script>

<style lang="css" scoped></style>
