<template>
    <div class="container mx-auto px-0">
        <LoadingTable v-if="loading" :headers="6" :row-count="10" />
           <Table v-else class="my-3 w-full overflow-clip rounded-lg border border-gray-100">
               <TableCaption>Lista de categorías</TableCaption>
               <TableHeader>
                   <TableRow>
                       <TableHead class="w-[100px] text-center">ID</TableHead>    
                       <TableHead class="w-[400px]">Nombre</TableHead>
                       <TableHead class="w-[300px]">Fecha de creación</TableHead>
                       <TableHead class="w-[250px]">Fecha de modificación</TableHead>
                       <TableHead class="w-[20px] text-center">Estado</TableHead>
                       <TableHead class="text-center w-[200px]">Acciones</TableHead>
                   </TableRow>
               </TableHeader>
               <TableBody class="cursor-pointer">
                   <TableRow v-for="category in categoryList" :key="category.id">
                       <td class="text-center font-bold">{{ category.id }}</td>
                       <td class="text-left px-3">{{ category.name }}</td>
                       <td class="text-left px-3">{{ category.created_at }}</td>
                       <td class="text-left px-4">{{ category.updated_at }}</td>
                       <td class="w-[200px] text-center">
                        <span v-if="category.status === true" class="rounded-full bg-green-400 px-2 py-1 text-white">Activo</span>
                        <span v-else class="rounded-full bg-red-400 px-2 py-1 text-white">Inactivo</span>
                       </td>
                       <td class="flex gap-2 justify-center">
                        <Button variant="outline" class="bg-orange-400 text-white shadow-md hover:bg-orange-600" @click="openModal(category.id)">
                            <UserPen class="h-5 w-5" />
                        </Button>
                        <Button variant="outline" class="bg-red-400 text-white shadow-md hover:bg-red-600" @click="openModalDelete(category.id)">
                            <Trash class="h-5 w-5" />
                        </Button>
                       </td>
                   </TableRow>
               </TableBody>
           </Table>
           <PaginationCategory :meta="categoryPaginate" @page-change="$emit('page-change', $event)"/>
   </div>
</template>
<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import { Pagination } from '@/interface/paginacion';
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Button from '@/components/ui/button/Button.vue';
import { usePage } from '@inertiajs/vue3';
import { SharedData } from '@/types';
import { onMounted, ref } from 'vue';
import { useToast } from '@/components/ui/toast';
import { Trash, UserPen } from 'lucide-vue-next';
import { CategoryResource } from '../interface/Category';
import PaginationCategory from '../../../../components/pagination.vue';

const { toast }  = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_category: number): void;
    (e: 'open-modal-delete', id_category: number): void;
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

const {categoryList,categoryPaginate} = defineProps<{
    categoryList: CategoryResource[];
    categoryPaginate: Pagination;
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