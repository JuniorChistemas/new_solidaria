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
                                <td class="cell-data text-center">{{ movement.code }}</td>
                                <td class="cell-data text-center">{{ formatDate(movement.issue_date) }}</td>
                                <td class="cell-data text-center">{{ formatDate(movement.credit_date) }}</td>
                                <td class="cell-data text-center">{{ movement.supplier.name }}</td> 
                                <td class="cell-data text-center">{{ movement.user.name }}</td>
                                <!-- Tipo Movimiento con Tailwind -->
                                <td class="cell-data text-center">
                                    <span :class="getTypeMovementClass(movement.typemovement.name)" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full"></span>
                                        {{ movement.typemovement.name }}
                                    </span>
                                </td>
                                <!-- Estado principal con Tailwind -->
                                <td class="cell-status text-center">
                                    <span v-if="movement.status === 1" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500 dark:bg-green-400"></span>
                                        Activo
                                    </span>
                                    <span v-if="movement.status === 0" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500 dark:bg-red-400"></span>
                                        Eliminado
                                    </span>
                                    <span v-if="movement.status === 2" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-orange-500 dark:bg-orange-400"></span>
                                        Anulado
                                    </span>
                                </td>
                                <!-- Estado IGV con Tailwind -->
                                <td class="cell-status text-center">
                                    <span v-if="movement.igv_status === 1" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-blue-500 dark:bg-blue-400"></span>
                                        Con IGV
                                    </span>
                                    <span v-else 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-gray-500 dark:bg-gray-400"></span>
                                        Sin IGV
                                    </span>
                                </td>
                                <!-- Tipo de Pago con Tailwind -->
                                <td class="cell-data text-center">
                                    <span :class="getPaymentTypeClass(movement.payment_type)" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full"></span>
                                        {{ movement.payment_type === 'contado' ? 'Contado' : 'Crédito' }}
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

const formatDate = (dateString) => {
  if (!dateString) return '';
  
  try {
    if (dateString.includes('T')) {
      return dateString.split('T')[0];
    }
   
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
// Función para determinar la clase del tipo de pago con Tailwind
const getPaymentTypeClass = (tipoPago) => {
  if (tipoPago === 'contado') {
    return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 [&>span]:bg-green-500 dark:[&>span]:bg-green-400';
  } else {
    return 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 [&>span]:bg-purple-500 dark:[&>span]:bg-purple-400';
  }
};

// Función para determinar la clase del tipo de movimiento con Tailwind
const getTypeMovementClass = (tipoMovimiento) => {
  switch(tipoMovimiento) {
    case 'Factura':
      return 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 [&>span]:bg-cyan-500 dark:[&>span]:bg-cyan-400';
    case 'Guía':
      return 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 [&>span]:bg-amber-500 dark:[&>span]:bg-amber-400';
    case 'Boleta':
      return 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 [&>span]:bg-pink-500 dark:[&>span]:bg-pink-400';
    case 'Venta':
      return 'bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 [&>span]:bg-sky-500 dark:[&>span]:bg-sky-400';
    default:
      return 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 [&>span]:bg-slate-500 dark:[&>span]:bg-slate-400';
  }
};
</script>
