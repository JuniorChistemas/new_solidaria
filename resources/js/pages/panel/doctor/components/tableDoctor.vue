<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="7" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <Table class="table-responsive">
                    <TableHeader class="table-header-row">
                        <TableRow>
                            <TableHead class="table-head-id">ID</TableHead>
                            <TableHead class="table-head">Nombre</TableHead>
                            <TableHead class="table-head">codigo</TableHead>
                            <TableHead class="table-head">fecha inicio</TableHead>
                            <TableHead class="table-head-status">estado</TableHead>
                            <TableHead class="table-head-actions">acciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="table-body">
                        <TableRow v-for="doctor in doctorList" :key="doctor.id" class="table-row">
                            <td class="cell-id">{{ doctor.id }}</td>
                            <td class="cell-data">{{ doctor.name }}</td>
                            <td class="cell-data">{{ doctor.code }}</td>
                            <td class="cell-data">{{ doctor.start_date }}</td>
                            <td class="cell-status">
                                <span v-if="doctor.state === true" class="status-badge status-active">
                                    <span class="status-indicator status-indicator-active"></span>
                                    Activo
                                </span>
                                <span v-else class="status-badge status-inactive">
                                    <span class="status-indicator status-indicator-inactive"></span>
                                    Inactivo
                                </span>
                            </td>
                            <td class="cell-actions">
                                <div class="actions-container">
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="action-button"
                                        @click="openModalEdit(doctor.id)"
                                        title="Editar proveedor"
                                    >
                                        <UserPen class="action-icon" />
                                        <span class="sr-only">Editar proveedor</span>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="action-button"
                                        @click="openModalDelete(doctor.id)"
                                        title="Eliminar proveedor"
                                    >
                                        <Trash class="action-icon" />
                                        <span class="sr-only">Eliminar proveedor</span>
                                    </Button>
                                </div>
                            </td>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <div class="pagination-container">
                <div class="pagination-summary">
                    Mostrando <span class="pagination-emphasis">{{ doctorPaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ doctorPaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ doctorPaginate.total }}</span> proveedores
                </div>
                <PaginationDoctors :meta="doctorPaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationDoctors from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { toast } from '@/utils/message';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { DoctorResource } from '../interface/Doctor';
const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id: number): void;
    (e: 'open-modal-delete', id: number): void;
}>();

const page = usePage<SharedData>();

const message = ref(page.props.flash?.message || '');

onMounted(() => {
    if (message.value) {
        toast({
            title: 'Notificación',
            description: message.value,
        });
    }
});

const { doctorList, doctorPaginate } = defineProps<{
    doctorList: DoctorResource[];
    doctorPaginate: Pagination;
    loading: boolean;
}>();

const openModalEdit = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};
</script>
<style scoped land="css"></style>
