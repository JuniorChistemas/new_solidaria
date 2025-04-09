<template>
  <div class="container-table">
    <LoadingTable v-if="loading" :headers="9" :row-count="12" />
    <div v-else class="table-content">
      <div class="table-container">
        <div class="table-responsive">
          <Table>
            <TableHeader class="table-header-row">
              <TableRow>
                <TableHead class="table-head-id">ID</TableHead>
                <TableHead class="table-head">Nombre</TableHead>
                <TableHead class="table-head">Dirección</TableHead>
                <TableHead class="table-head">Serie</TableHead>
                <TableHead class="table-head">Nota de la Serie</TableHead>
                <TableHead class="table-head">Fecha de Creación</TableHead>
                <TableHead class="table-head">Fecha de Modificación</TableHead>
                <TableHead class="table-head-status">Estado</TableHead>
                <TableHead class="table-head-actions">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody class="table-body">
              <TableRow v-for="local in localList" :key="local.id" class="table-row">
                <td class="cell-id">{{ local.id }}</td>
                <td class="cell-data">{{ local.name }}</td>
                <td class="cell-data">{{ local.address }}</td>
                <td class="cell-data">{{ local.series }}</td>
                <td class="cell-data">{{ local.series_note || '-' }}</td>
                <td class="cell-data">{{ local.created_at }}</td>
                <td class="cell-data">{{ local.updated_at }}</td>
                <td class="cell-status">
                  <span v-if="local.status === true" class="status-badge status-active">
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
                      @click="openModal(local.id)"
                      title="Editar local"
                    >
                      <UserPen class="action-icon" />
                      <span class="sr-only">Editar local</span>
                    </Button>
                    <Button
                      variant="ghost"
                      size="sm"
                      class="action-button"
                      @click="openModalDelete(local.id)"
                      title="Eliminar local"
                    >
                      <Trash class="action-icon" />
                      <span class="sr-only">Eliminar local</span>
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
          Mostrando
          <span class="pagination-emphasis">{{ localPaginate.from || 0 }}</span>
          a
          <span class="pagination-emphasis">{{ localPaginate.to || 0 }}</span>
          de
          <span class="pagination-emphasis">{{ localPaginate.total }}</span>
          locales
        </div>
        <PaginationLocal :meta="localPaginate" @page-change="$emit('page-change', $event)" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationLocal from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { LocalResource } from '../interface/Local';

const { toast } = useToast();

const emit = defineEmits<{
  (e: 'page-change', page: number): void;
  (e: 'open-modal', id_local: number): void;
  (e: 'open-modal-delete', id_local: number): void;
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

const { localList, localPaginate, loading } = defineProps<{
  localList: LocalResource[];
  localPaginate: Pagination;
  loading: boolean;
}>();

const openModal = (id: number) => {
  emit('open-modal', id);
};

const openModalDelete = (id: number) => {
  emit('open-modal-delete', id);
};
</script>

<style scoped lang="css">
/* Aquí puedes agregar tus estilos CSS personalizados */
</style>
