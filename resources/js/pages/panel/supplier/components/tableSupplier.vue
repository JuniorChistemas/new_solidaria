<template>
    <div class="container mx-auto px-0">
        <LoadingTable v-if="loading" :headers="6" :row-count="10" />
           <Table v-else class="my-3 w-full overflow-clip rounded-lg border border-gray-100">
               <TableCaption>Lista de proveedores</TableCaption>
               <TableHeader>
                   <TableRow>
                       <TableHead class="text-center">ID</TableHead>    
                       <TableHead class="w-[200px]">Nombre</TableHead>
                       <TableHead class="text-left px-10">Ruc</TableHead>
                       <TableHead class="text-left px-10">Teléfono</TableHead>
                       <TableHead class="text-left px-1">Dirección</TableHead>
                       <TableHead>Estado</TableHead>
                       <TableHead class="text-center">Acciones</TableHead>
                   </TableRow>
               </TableHeader>
               <TableBody class="cursor-pointer">
                   <TableRow v-for="supplier in supplierList" :key="supplier.id">
                       <td class="text-center font-bold">{{ supplier.id }}</td>
                       <td class="text-left px-2">{{ supplier.name }}</td>
                       <td class="text-left px-10">{{ supplier.ruc }}</td>
                       <td class="text-left px-10">{{ supplier.phone }}</td>
                       <td>{{ supplier.address }}</td>
                       <td class="w-[100px] text-center">
                        <span v-if="supplier.state === true" class="rounded-full bg-green-400 px-2 py-1 text-white">Activo</span>
                        <span v-else class="rounded-full bg-red-400 px-2 py-1 text-white">Inactivo</span>
                       </td>
                       <td class="flex gap-2 justify-center">
                        <Button variant="outline" class="bg-orange-400 text-white shadow-md hover:bg-orange-600" @click="openModal(supplier.id)">
                            <UserPen class="h-5 w-5" />
                        </Button>
                        <Button variant="outline" class="bg-red-400 text-white shadow-md hover:bg-red-600" @click="openModalDelete(supplier.id)">
                            <Trash class="h-5 w-5" />
                        </Button>
                       </td>
                   </TableRow>
               </TableBody>
           </Table>
           <PaginationSupplier :meta="supplierPaginate" @page-change="$emit('page-change', $event)"/>
   </div>
</template>
<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import { Pagination } from '@/interface/paginacion';
import { SupplierResource } from '../interface/Supplier';
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Button from '@/components/ui/button/Button.vue';
import { usePage } from '@inertiajs/vue3';
import { SharedData } from '@/types';
import { onMounted, ref } from 'vue';
import { useToast } from '@/components/ui/toast';
import PaginationSupplier from '../../../../components/pagination.vue';
import { Trash, UserPen } from 'lucide-vue-next';

const { toast }  = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_supplier: number): void;
    (e: 'open-modal-delete', id_supplier: number): void;
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

const {supplierList,supplierPaginate} = defineProps<{
   supplierList: SupplierResource[];
   supplierPaginate: Pagination;
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