<template>
    <Head title="zone"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterZone @search="searchZone" />
                <TableZone
                    :zone-list="principal.zoneList"
                    :zone-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdZone"
                    @open-modal-delete="openDeleteModal"
                    :loading="principal.loading"
                />
                <EditZone
                    :zone-data="principal.zoneData"
                    :modal="principal.statusModal.update"
                    @emit-close="closeModal"
                    @update-zone="emitUpdateZone"
                />
                <DeleteZone
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idZone"
                    title="Eliminar Zone"
                    description="¿Está seguro de que desea eliminar esta zona?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteZone"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import DeleteZone from '@/components/delete.vue';
import FilterZone from '@/components/filter.vue';
import { useZone } from '@/composables/useZone';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditZone from './components/editZone.vue';
import TableZone from './components/tableZone.vue';
import { ZoneUpdateRequest } from './interface/Zone';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear Zona',
        href: '/panel/zones/create',
    },
    {
        title: 'Zonas',
        href: '/panel/zones',
    },
];

onMounted(() => {
    loadingZones();
});

const { principal, loadingZones, getZoneById, updateZone, deleteZone } = useZone();

// get pagination
const handlePageChange = (page: number) => {
    console.log(page);
    loadingZones(page);
};
// get zones by id for edit
const getIdZone = (id: number) => {
    getZoneById(id);
};
// close modal
const closeModal = (open: boolean) => {
    principal.statusModal.update = open;
};
// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};

// update zone
const emitUpdateZone = (zone: ZoneUpdateRequest, id_zone: number) => {
    updateZone(id_zone, zone);
};

// delete zone
const openDeleteModal = (zoneId: number) => {
    principal.statusModal.delete = true;
    principal.idZone = zoneId;
    console.log('Eliminar Zona con ID:', zoneId);
};
// delete zone
const emitDeleteZone = (zoneId: number | string) => {
    deleteZone(Number(zoneId));
};
// search zone
const searchZone = (text: string) => {
    loadingZones(1, text);
};
</script>
<style lang="css" scoped></style>
