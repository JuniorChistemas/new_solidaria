<template>
    <div class="container-table">
        <!-- Filtros con comboboxes uno al lado del otro -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full sm:w-72">
                <label class="text-sm font-medium mb-1 block">Categoría</label>
                <CategoryCombobox @select="handleCategorySelect" />
            </div>
            <div class="w-full sm:w-72">
                <label class="text-sm font-medium mb-1 block">Laboratorio</label>
                <LaboratoryCombobox @select="handleLaboratorySelect" />
            </div>
            <div class="w-full sm:w-72">
                <label class="text-sm font-medium mb-1 block">Local</label>
                <LocalCombobox @select="handleLocalSelect" />
            </div>
        </div>

        <LoadingTable v-if="loading" :headers="8" :row-count="12" />
        <div v-else class="table-content">
            <div class="table-container">
                <div class="table-responsive">
                    <Table>
                        <TableHeader class="table-header-row">
                            <TableRow>
                                <TableHead class="table-head-id text-center">ID</TableHead>
                                <TableHead class="table-head text-center">Nombre</TableHead>
                                <TableHead class="table-head text-center">Composición</TableHead>
                                <TableHead class="table-head text-center">Presentación</TableHead>
                                <TableHead class="table-head text-center">Laboratorio</TableHead>
                                <TableHead class="table-head text-center">Categoría</TableHead>
                                <TableHead class="table-head text-center">Cajas</TableHead>
                                <TableHead class="table-head text-center">Fracciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody class="table-body">
                            <TableRow v-for="product in productList" :key="product.id" class="table-row">
                                <td class="cell-id text-center">{{ product.id }}</td>
                                <td class="cell-data text-center">{{ product.nombre }}</td>
                                <td class="cell-data text-center">{{ product.composicion }}</td>
                                <td class="cell-data text-center">{{ product.presentacion }}</td>
                                <td class="cell-data text-center">{{ product.laboratorio }}</td>
                                <td class="cell-data text-center">{{ product.categoria }}</td>
                                <td class="cell-data text-center">
                                    <span 
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-blue-500 dark:bg-blue-400"></span>
                                        {{ product.cajas }}
                                    </span>
                                </td>
                                <td class="cell-data text-center">
                                    <span 
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-purple-500 dark:bg-purple-400"></span>
                                        {{ product.fracciones }}
                                    </span>
                                </td>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
            <div class="pagination-container">
                <div class="pagination-summary">
                    Mostrando <span class="pagination-emphasis">{{ productPaginate.from || 0 }}</span> a
                    <span class="pagination-emphasis">{{ productPaginate.to || 0 }}</span> de
                    <span class="pagination-emphasis">{{ productPaginate.total }}</span> productos
                </div>
                <PaginationInventory :meta="productPaginate" @page-change="$emit('page-change', $event)" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import PaginationInventory from '@/components/pagination.vue';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { InventoryResource } from '../interface/Inventory';
import CategoryCombobox from '@/components/Inputs/CategoryCombobox.vue';
import LaboratoryCombobox from '@/components/Inputs/LaboratoryCombobox.vue';
import LocalCombobox from '@/components/Inputs/LocalCombobox.vue';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_product: number): void;
    (e: 'open-modal-delete', id_product: number): void;
    (e: 'filter-category', category_id: number): void;
    (e: 'filter-laboratory', laboratory_id: number): void;
    (e: 'filter-local', local_id: number): void;
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

const { productList, productPaginate, loading } = defineProps<{
    productList: InventoryResource[];
    productPaginate: Pagination;
    loading: boolean;
}>();

// Handlers para los comboboxes
const handleCategorySelect = (category_id: number) => {
    emit('filter-category', category_id);
};

const handleLaboratorySelect = (laboratory_id: number) => {
    emit('filter-laboratory', laboratory_id);
};

const handleLocalSelect = (local_id: number) => {
    emit('filter-local', local_id);
};
</script>