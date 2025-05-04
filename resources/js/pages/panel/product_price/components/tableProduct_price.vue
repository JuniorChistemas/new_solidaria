<template>
    <div class="container-table">
        <LoadingTable v-if="loading" :headers="6" :row-count="10" />
        <div v-else class="table-content">
            <div class="table-container">
                <Table class="table-responsive">
                    <TableHeader class="table-header-row">
                        <TableRow class="table-header-row">
                            <TableHead class="table-head-id">ID</TableHead>
                            <TableHead class="table-head">NOMBRE</TableHead>
                            <TableHead class="table-head">PRECIO CAJA</TableHead>
                            <TableHead class="table-head">PRECIO FRACCION</TableHead>
                            <TableHead class="table-head-actions">ACCIONES</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="table-body">
                        <TableRow v-for="productprice in productList" :key="productprice.id" class="table-row">
                            <td class="cell-id">{{ productprice.id }}</td>
                            <td class="cell-data">{{ productprice.product }}</td>
                            <td class="cell-data">{{ productprice.box_price }}</td>
                            <td class="cell-data">{{ productprice.fraction_price }}</td>
                            <td class="cell-actions">
                                <div class="actions-container">
                                    <Button variant="ghost" size="sm" class="action-button" @click="openModal(productprice.product_id)" title="Editar producto">
                                        <UserPen class="action-icon" />
                                        <span class="sr-only">Editar producto</span>
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="action-button"
                                        @click="openModalDelete(productprice.product_id)"
                                        title="Eliminar producto"
                                    >
                                        <Trash class="action-icon" />
                                        <span class="sr-only">Eliminar producto</span>
                                    </Button>
                                </div>
                            </td>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <PaginationProduct :meta="productPaginate" @page-change="$emit('page-change', $event)" class="mt-6" />
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import PaginationProduct from '../../../../components/pagination.vue';
import { ProductpriceResource } from '../interface/Product_price';

const { toast } = useToast();
const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_product: number): void;
    (e: 'open-modal-delete', id_product: number): void;
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

const { productList, productPaginate } = defineProps<{
    productList: ProductpriceResource[];
    productPaginate: Pagination;
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
