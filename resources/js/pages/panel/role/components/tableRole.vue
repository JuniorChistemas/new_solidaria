<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="7" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head-id">ID</TableHead>
                                <TableHead class="table-head">Nombre</TableHead>
                                <!--TableHead class="table-head">Permisos</TableHead-->
                                <TableHead class="table-head">Fecha de creación</TableHead>
                                <TableHead class="table-head">Fecha de modificación</TableHead>
                                <TableHead class="table-head-actions">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="role in roleList" :key="role.id" class="table-row">
                                <td class="cell-id">{{ role.id }}</td>
                                <td class="cell-data">{{ role.name }}</td>
                                <!--select
                                    class="form-select block w-full mt-2 py-1 px-3 border border-gray-300 dark:text-black rounded-md shadow-sm focus:outline-none focus:ring focus:ring-orange-400 focus:ring-opacity-50">
                                        <option v-for="permiso in role.permisos" :key="permiso.id">
                                            {{ permiso.name }}
                                        </option>
                                 </select-->
                                <td class="cell-data">{{ role.created_at }}</td>
                                <td class="cell-data">{{ role.updated_at }}</td>
                                <td class="cell-actions">
                                    <div class="actions-container">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openFormEditPermission(role.id)"
                                            title="Editar rol"
                                        >
                                            <UserPen class="action-icon" />
                                            <span class="sr-only">Editar rol</span>
                                        </Button>
                                        <!--Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openFormEditPermission(role.id)"
                                            title="Gestionar permisos"
                                        >
                                            <KeyRound class="action-icon" />
                                            <span class="sr-only">Gestionar permisos</span>
                                        </Button-->

                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openModalDelete(role.id)"
                                            title="Eliminar rol"
                                        >
                                            <Trash class="action-icon" />
                                            <span class="sr-only">Eliminar rol</span>
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
                    Mostrando <span class="pagination-emphasis">{{ rolePaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ rolePaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ rolePaginate.total }}</span> roles
                </div>
                <PaginationRole :meta="rolePaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationRole from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen, KeyRound } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { RoleResource } from '../interface/Role';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_role: number): void;
    (e: 'open-modal-delete', id_role: number): void;
    (e: 'open-modal-permissions', id_role: number): void; //HICE CAMBIOS
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

const { roleList, rolePaginate } = defineProps<{
    roleList: RoleResource[];
    rolePaginate: Pagination;
    loading: boolean;
}>();

const openModal = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};

//HICE CAMBIOS
const openFormEditPermission = (id: number) => {
    window.location.href = `/panel/roles/${id}/edit`;
};

</script>

<style scoped lang="css">
.table-row .cell-id,
.table-row .cell-data {
    padding-right: 10px; /* Reduce el espaciado en las celdas de la tabla */
}

.form-select {
    max-width: 150px; /* Limita aún más el ancho del select */
    width: auto; /* Ajusta al contenido */
    white-space: nowrap; /* Evita el ajuste de texto y asegura que no se expanda más allá */
}

.table-header-row .table-head,
.table-row .cell-data {
    padding: 10px 15px; /* Ajusta el padding en las celdas de la tabla */
}

.table-container {
    padding-right: 0; /* Elimina el margen extra en la tabla */
}

</style>