<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="5" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head-id">ID</TableHead>
                                <TableHead class="table-head">Nombre</TableHead>
                                <TableHead class="table-head">Fecha de creación</TableHead>
                                <TableHead class="table-head">Fecha de modificación</TableHead>
                                <TableHead class="table-head-actions">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="permission in permissionList" :key="permission.id" class="table-row">
                                <td class="cell-id">{{ permission.id }}</td>
                                <td class="cell-data">{{ permission.name }}</td>
                                <td class="cell-data">{{ permission.created_at }}</td>
                                <td class="cell-data">{{ permission.updated_at }}</td>
                                <td class="cell-actions">
                                    <div class="actions-container">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openModal(permission.id)"
                                            title="Editar permiso"
                                        >
                                            <UserPen class="action-icon" />
                                            <span class="sr-only">Editar permiso</span>
                                        </Button>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openModalDelete(permission.id)"
                                            title="Eliminar permiso"
                                        >
                                            <Trash class="action-icon" />
                                            <span class="sr-only">Eliminar permiso</span>
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
                    Mostrando <span class="pagination-emphasis">{{ permissionPaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ permissionPaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ permissionPaginate.total }}</span> permisos
                </div>
                <PaginationPermission :meta="permissionPaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationPermission from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { PermissionResource } from '../interface/Permission';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_permission: number): void;
    (e: 'open-modal-delete', id_permission: number): void;
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

const { permissionList, permissionPaginate } = defineProps<{
    permissionList: PermissionResource[];
    permissionPaginate: Pagination;
    loading: boolean;
}>();

const openModal = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};
</script>

<style scoped></style>
