<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="7" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader>
                            <TableRow class="table-header-row">
                                <TableHead class="table-head-id">N°</TableHead>
                                <TableHead class="table-head">Laboratorio</TableHead>
                                <TableHead class="table-head">Fecha de creación</TableHead>
                                <TableHead class="table-head">Fecha de modificación</TableHead>
                                <TableHead class="table-head-status">Estado</TableHead>
                                <TableHead class="table-head-actions">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="laboratory in laboratoryList" :key="laboratory.id" class="table-row">
                                <td class="cell-id">{{ laboratory.id }}</td>
                                <td class="cell-data">{{ laboratory.name }}</td>
                                <td class="cell-data">{{ laboratory.created_at }}</td>
                                <td class="cell-data">{{ laboratory.updated_at }}</td>
                                <td class="cell-status">
                                    <span v-if="laboratory.state" class="status-badge status-active">
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
                                            @click="openModal(laboratory.id)"
                                            title="Editar laboratorio"
                                        >
                                            <UserPen class="action-icon" />
                                            <span class="sr-only">Editar laboratorio</span>
                                        </Button>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            class="action-button"
                                            @click="openModalDelete(laboratory.id)"
                                            title="Eliminar laboratorio"
                                        >
                                            <Trash class="action-icon" />
                                            <span class="sr-only">Eliminar laboratorio</span>
                                        </Button>
                                    </div>
                                </td>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>

            <div class="pagination-container">
                <div class="pagination-summary">
                    Mostrando <span class="pagination-emphasis">{{ laboratoryPaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ laboratoryPaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ laboratoryPaginate.total }}</span> laboratorios
                </div>
                <PaginationLaboratory :meta="laboratoryPaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationLaboratory from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { LaboratoryResource } from '../interface/Laboratory';
//import PaginationLaboratory from './paginationLaboratory.vue';
import { Trash, UserPen } from 'lucide-vue-next';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_laboratory: number): void;
    (e: 'open-modal-delete', id_laboratory: number): void;
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

const { laboratoryList, laboratoryPaginate, loading } = defineProps<{
    laboratoryList: LaboratoryResource[];
    laboratoryPaginate: Pagination;
    loading: boolean;
}>();

const openModal = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};
</script>

<style scoped lang="css"></style>
