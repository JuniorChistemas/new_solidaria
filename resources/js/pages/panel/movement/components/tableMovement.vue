<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="10" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head-id">ID</TableHead>
                                <TableHead class="table-head">Código</TableHead>
                                <TableHead class="table-head">Fecha Emisión</TableHead>
                                <TableHead class="table-head">Fecha Credito</TableHead>
                                <TableHead class="table-head">Proveedor</TableHead>
                                <TableHead class="table-head">Usuario</TableHead>
                                <TableHead class="table-head">Tipo Movimiento</TableHead>
                                <TableHead class="table-head-status">Estado</TableHead>
                                <TableHead class="table-head-status">Estado IGV</TableHead>
                                <TableHead class="table-head">Tipo Pago</TableHead>
                                <TableHead class="table-head-actions">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="movement in movementList" :key="movement.id" class="table-row">
                                <td class="cell-id">{{ movement.id }}</td>
                                <td class="cell-data">{{ movement.codigo }}</td>
                                <td class="cell-data">{{ formatDate(movement.fechaEmision) }}</td>
                                <td class="cell-data">{{ formatDate(movement.fechaCredito) }}</td>
                                <td class="cell-data">{{ movement.supplier.name }}</td>  <!-- Nombre del proveedor -->
                                <td class="cell-data">{{ movement.user.name }}</td>  <!-- Nombre del local -->
                                <td class="cell-data">{{ movement.typemovement.nombre }}</td> <!-- Show the movement type text -->
                              <!-- Estado principal -->
                                <td class="cell-status">
                                    <span v-if="movement.estado === 1" class="status-badge status-active">
                                        <span class="status-indicator status-indicator-active"></span>
                                        Activo
                                    </span>
                                    <span v-if="movement.estado === 0" class="status-badge status-inactive">
                                        <span class="status-indicator status-indicator-inactive"></span>
                                        Eliminado
                                    </span>
                                    <span v-if="movement.estado === 2" class="status-badge status-anulado">
                                        <span class="status-indicator status-indicator-anulado"></span>
                                        Anulado
                                    </span>
                                </td>
                                <!-- Estado IGV -->
                                <td class="cell-status">
                                    <span v-if="movement.estadoIgv === 1" class="status-badge status-active">
                                        <span class="status-indicator status-indicator-active"></span>
                                        Con IGV
                                    </span>
                                    <span v-else class="status-badge status-inactive">
                                        <span class="status-indicator status-indicator-inactive"></span>
                                        Sin IGV
                                    </span>
                                </td>
                                <!-- Tipo de Pago -->
                                <td class="cell-data">
                                    <span>{{ movement.tipoPago === 'contado' ? 'Contado' : 'Crédito' }}</span>
                                </td>
                                <!-- Acciones -->
                                <td class="cell-actions">
                                    <div class="actions-container">
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openModal(movement.id)"
                                            title="Editar movimiento"
                                        >
                                            <UserPen class="action-icon" />
                                            <span class="sr-only">Editar movimiento</span>
                                        </Button>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="action-button"
                                            @click="openModalDelete(movement.id)"
                                            title="Eliminar movimiento"
                                        >
                                            <Trash class="action-icon" />
                                            <span class="sr-only">Eliminar movimiento</span>
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
                    Mostrando <span class="pagination-emphasis">{{ movementPaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ movementPaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ movementPaginate.total }}</span> movimientos
                </div>
                <PaginationMovement :meta="movementPaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationMovement from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { MovementResource } from '../interface/Movement';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_movement: number): void;
    (e: 'open-modal-delete', id_movement: number): void;
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

const { movementList, movementPaginate } = defineProps<{
    movementList: MovementResource[];
    movementPaginate: Pagination;
    loading: boolean;
}>();

const openModal = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};

const formatDate = (dateString) => {
  if (!dateString) return 'No disponible';
  
  try {
    // Extraemos directamente las partes de la cadena ISO
    const [year, month, day] = dateString.split('T')[0].split('-');
    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
  } catch (e) {
    return 'Fecha inválida';
  }
};
</script>

<style scoped lang="css">
.tipo-pago-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
}

.tipo-pago-contado {
    background-color: #dcfce7;
    color: #166534;
}

.tipo-pago-credito {
    background-color: #ffedd5;
    color: #9a3412;
}

.status-anulado {
    background-color: rgba(234, 88, 12, 0.15);
    color: #f97316;
    padding: 0.20rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0;
}

.status-anulado::before {
    content: "";
    width: 0.4rem;
    height: 0.4rem;
    background-color: #f97316;
    border-radius: 9999px;
    margin-right: -2px; 
}

</style>