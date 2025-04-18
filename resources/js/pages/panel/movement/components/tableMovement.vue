<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="10" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head-id text-center">ID</TableHead>
                                <TableHead class="table-head text-center">Código</TableHead>
                                <TableHead class="table-head text-center">Fecha Emisión</TableHead>
                                <TableHead class="table-head text-center">Fecha Credito</TableHead>
                                <TableHead class="table-head text-center">Proveedor</TableHead>
                                <TableHead class="table-head text-center">Usuario</TableHead>
                                <TableHead class="table-head text-center">Tipo Movimiento</TableHead>
                                <TableHead class="table-head-status text-center">Estado</TableHead>
                                <TableHead class="table-head-status text-center">Estado IGV</TableHead>
                                <TableHead class="table-head text-center">Tipo Pago</TableHead>
                                <TableHead class="table-head-actions text-center">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="movement in movementList" :key="movement.id" class="table-row">
                                <td class="cell-id text-center">{{ movement.id }}</td>
                                <td class="cell-data text-center">{{ movement.codigo }}</td>
                                <td class="cell-data text-center">{{ formatDate(movement.fechaEmision) }}</td>
                                <td class="cell-data text-center">{{ formatDate(movement.fechaCredito) }}</td>
                                <td class="cell-data text-center">{{ movement.supplier.name }}</td> 
                                <td class="cell-data text-center">{{ movement.user.name }}</td>
                                <!-- Tipo Movimiento con estilos -->
                                <td class="cell-data text-center">
                                    <span :class="getTypeMovementClass(movement.typemovement.nombre)" class="type-movement-badge">
                                        <span class="type-indicator"></span>
                                        {{ movement.typemovement.nombre }}
                                    </span>
                                </td>
                              <!-- Estado principal -->
                                <td class="cell-status text-center">
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
                                <td class="cell-status text-center">
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
                                <td class="cell-data text-center">
                                    <span :class="getPaymentTypeClass(movement.tipoPago)" class="payment-type-badge">
                                        <span class="payment-indicator"></span>
                                        {{ movement.tipoPago === 'contado' ? 'Contado' : 'Crédito' }}
                                    </span>
                                </td>
                                <!-- Acciones -->
                                <td class="cell-actions text-center">
                                    <div class="actions-container justify-center">
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

// Add this function to your edit modal component
const formatDate = (dateString) => {
  if (!dateString) return '';
  
  try {
    // If the date is already in ISO format (YYYY-MM-DDT...)
    if (dateString.includes('T')) {
      return dateString.split('T')[0]; // Returns YYYY-MM-DD
    }
    
    // If the date is in DD/MM/YYYY format (as displayed in the table)
    if (dateString.includes('/')) {
      const [day, month, year] = dateString.split('/');
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }
    
    return dateString;
  } catch (e) {
    console.error('Error formatting date:', e);
    return '';
  }
};

// Función para determinar la clase del tipo de pago
const getPaymentTypeClass = (tipoPago) => {
  return tipoPago === 'contado' ? 'payment-type-contado' : 'payment-type-credito';
};

// Función para determinar la clase del tipo de movimiento
const getTypeMovementClass = (tipoMovimiento) => {
  switch(tipoMovimiento) {
    case 'Factura':
      return 'type-factura';
    case 'Guía':
      return 'type-guia';
    case 'Boleta':
      return 'type-boleta';
    case 'Venta':
      return 'type-venta';
    default:
      return 'type-default';
  }
};
</script>

<style scoped lang="css">
/* Estilos existentes */
.tipo-pago-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
}


.status-anulado {
    background-color: rgba(234, 88, 12, 0.15);
    color: #e4c6b1;
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

/* Nuevos estilos para tipo de pago */
.payment-type-badge {
    padding: 0.20rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.payment-type-contado {
    background-color: rgba(33, 104, 65, 0.24);
    color: #beecc6;
}

.payment-type-credito {
    background-color: rgba(124, 58, 237, 0.15);
    color: #dddae2;
}

.payment-indicator {
    content: "";
    width: 0.4rem;
    height: 0.4rem;
    border-radius: 9999px;
    display: inline-block;
}

.payment-type-contado .payment-indicator {

    background-color: #0caa61;
}

.payment-type-credito .payment-indicator {
    background-color: #7c3aed;
}

/* Estilos para tipo de movimiento */
.type-movement-badge {
    padding: 0.20rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.type-factura {
    background-color: rgba(6, 182, 212, 0.15);
    color: #b9c9cc;
}

.type-guia {
    background-color: rgba(245, 158, 11, 0.15);
    color: #eedec2;
}

.type-boleta {
    background-color: rgba(236, 72, 153, 0.15);
    color: #d1acbf;
}

.type-venta {
    background-color: rgba(14, 165, 233, 0.15);
    color: #bed7e2;
}

.type-default {
    background-color: rgba(100, 116, 139, 0.15);
    color: #747b85;
}

.type-indicator {
    content: "";
    width: 0.4rem;
    height: 0.4rem;
    border-radius: 9999px;
    display: inline-block;
}

.type-factura .type-indicator {
    background-color: #06b6d4;
}

.type-guia .type-indicator {
    background-color: #f59e0b;
}

.type-boleta .type-indicator {
    background-color: #ec4899;
}

.type-venta .type-indicator {
    background-color: #0ea5e9;
}

.type-default .type-indicator {
    background-color: #64748b;
}
</style>