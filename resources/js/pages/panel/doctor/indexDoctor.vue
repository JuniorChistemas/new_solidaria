<template>
    <Head title="Doctores"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-2">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <FilterDoctor @search="searchDoctor" />
                <TableDoctor
                    :doctor-list="principal.doctorList"
                    :doctor-paginate="principal.paginacion"
                    @page-change="handlePageChange"
                    @open-modal="getIdDoctor"
                    @open-modal-delete="openModalDelete"
                    :loading="principal.loading"
                />
                <EditDoctor
                    :modal="principal.statusModal.update"
                    :doctor-data="principal.doctorData"
                    @emit-close="closeModal"
                    @update-doctor="emitUpdateDoctor"
                />
                <DeleteDoctor
                    :modal="principal.statusModal.delete"
                    :itemId="principal.idDoctor"
                    title="Eliminar Proveedor"
                    description="¿Está seguro de que desea eliminar este proveedor?"
                    @close-modal="closeModalDelete"
                    @delete-item="emitDeleteDoctor"
                />
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import DeleteDoctor from '@/components/delete.vue';
import FilterDoctor from '@/components/filter.vue';
import { useDoctors } from '@/composables/useDoctor';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import EditDoctor from './components/editDoctor.vue';
import TableDoctor from './components/tableDoctor.vue';
import { updateDoctorRequest } from './interface/Doctor';

const { principal, loadingDoctors, getDoctor, updateDoctor, deleteDoctor } = useDoctors();

onMounted(() => {
    loadingDoctors();
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Crear doctor',
        href: '/panel/doctors/create',
    },
    // {
    //     title: 'Exportar a Excel',
    //     href: '/panel/reports/export-excel-suppliers',
    //     download: true,
    // },
    // {
    //     title: 'Exportar a PDF',
    //     href: '/panel/reports/export-pdf-suppliers',
    //     download: true,
    // },
    {
        title: 'Doctores',
        href: '/panel/doctors',
    },
];

// get pagination

const handlePageChange = (page: number) => {
    console.log(page);
    loadingDoctors(page);
};
// get doctor by id for edit
const getIdDoctor = (id: number) => {
    getDoctor(id);
};
// close modal
const closeModal = (open: boolean) => {
    console.log('close modal2');
    principal.statusModal.update = open;
};

// close modal delete
const closeModalDelete = (open: boolean) => {
    principal.statusModal.delete = open;
};
// update doctor
const emitUpdateDoctor = (doctor: updateDoctorRequest, id_doctor: number) => {
    updateDoctor(id_doctor, doctor);
};

// open modal delete
const openModalDelete = (id_doctor: number) => {
    principal.statusModal.delete = true;
    principal.idDoctor = id_doctor;
};

// delete doctor
const emitDeleteDoctor = (doctorId: number | string) => {
    deleteDoctor(Number(doctorId));
};

//  search doctor
const searchDoctor = (search: string) => {
    loadingDoctors(1, search);
};
</script>
<style scoped></style>
