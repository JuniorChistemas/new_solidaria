<template>
    <div class="container mx-auto px-0">
        <LoadingTable v-if="loading" :headers="4" :row-count="10" />
        <Table v-else class="my-3 w-full overflow-clip rounded-lg border border-gray-100">
            <TableCaption>Laboratorio {{ laboratoryPaginate.current_page }} de {{ laboratoryPaginate.total }} Laboratorios</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="text-center">N°</TableHead>
                    <TableHead class="w-[250px]">Laboratorio</TableHead>
                    <TableHead class="w-[200px]">Fecha de creación</TableHead>
                    <TableHead class="w-[200px]">Fecha de modificación</TableHead>
                    <TableHead>Estado</TableHead>
                    <TableHead class="text-center">Acciones</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody class="cursor-pointer">
                <TableRow v-for="laboratory in laboratoryList" :key="laboratory.id">
                    <td class="text-center font-bold">{{ laboratory.id }}</td>
                    <td>{{ laboratory.name }}</td>
                    <td>{{ laboratory.created_at }}</td>
                    <td>{{ laboratory.updated_at }}</td>
                    <td class="w-[100px] text-center">
                        <span v-if="laboratory.state" class="rounded-full bg-green-400 px-2 py-1 text-white">Activo</span>
                        <span v-else class="rounded-full bg-red-400 px-2 py-1 text-white">Inactivo</span>
                    </td>
                    <td class="flex justify-center gap-2">
                        <Button variant="outline" class="bg-orange-400 text-white shadow-md hover:bg-orange-600" @click="openModal(laboratory.id)">
                            <UserPen class="h-5 w-5" />
                        </Button>
                        <Button variant="outline" class="bg-red-400 text-white shadow-md hover:bg-red-600" @click="openModalDelete(laboratory.id)">
                            <Trash class="h-5 w-5" />
                        </Button>
                    </td>
                </TableRow>
            </TableBody>
        </Table>
        <PaginationLaboratory :meta="laboratoryPaginate" @page-change="$emit('page-change', $event)" />
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { LaboratoryResource } from '../interface/Laboratory';
//import PaginationLaboratory from './paginationLaboratory.vue';
import { Trash, UserPen } from 'lucide-vue-next';

const { toast } = useToast();

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_laboratory: number): void;
    (e: 'open-modal-delete', id_laboratory: number): void;
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

const { laboratoryList, laboratoryPaginate, loading } = defineProps<{
    laboratoryList: LaboratoryResource[];
    laboratoryPaginate: Pagination;
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
