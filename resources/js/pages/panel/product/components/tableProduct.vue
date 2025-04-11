<template>
    <div class="container mx-auto px-4 py-2">
        <LoadingTable v-if="loading" :headers="6" :row-count="10" />
        <div v-else class="space-y-4">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-700 dark:shadow-none">
                <Table class="w-full">
                    <TableHeader class="bg-gray-50 dark:bg-gray-800/50">
                        <TableRow class="hover:bg-transparent">
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">ID</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">NOMBRE</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">COMPOSICIÓN</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">PRESENTACIÓN</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">FORM_FARM</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">CODIGOB</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">LABORATORIO</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">CATEGORIA</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">FRACCIÓN</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">IGV</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">ESTADO</TableHead>
                            <TableHead class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">ACCIONES</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <TableRow
                            v-for="product in productList"
                            :key="product.id"
                            class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/30"
                        >
                            <TableCell class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ product.id }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.name }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.composition }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.presentation }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.form_farm }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.barcode }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.laboratory }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ product.category }}</TableCell>
                            <TableCell class="px-4 py-3">
                                <span
                                    v-if="product.state_fraction === true"
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-500 dark:bg-green-400"></span>
                                    Fraccionable
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-500 dark:bg-red-400"></span>
                                    No fraccionable
                                </span>
                            </TableCell>
                            <TableCell class="px-4 py-3">
                                <span
                                    v-if="product.state_igv === true"
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-500 dark:bg-green-400"></span>
                                    Afectado
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-500 dark:bg-red-400"></span>
                                    Inafectado
                                </span>
                            </TableCell>
                            <TableCell class="px-4 py-3">
                                <span
                                    v-if="product.state === true"
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-500 dark:bg-green-400"></span>
                                    Activo
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-500 dark:bg-red-400"></span>
                                    Inactivo
                                </span>
                            </TableCell>
                            <TableCell class="flex justify-end space-x-2 px-4 py-3">
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    class="h-8 w-8 p-0 text-orange-600 hover:bg-orange-50 hover:text-orange-700 dark:text-orange-400 dark:hover:bg-orange-900/30 dark:hover:text-orange-300"
                                    @click="openModal(product.id)"
                                    title="Editar producto"
                                >
                                    <UserPen class="h-4 w-4" />
                                    <span class="sr-only">Editar Producto</span>
                                </Button>
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    class="h-8 w-8 p-0 text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/30 dark:hover:text-red-300"
                                    @click="openModalDelete(product.id)"
                                    title="Eliminar producto"
                                >
                                    <Trash class="h-4 w-4" />
                                    <span class="sr-only">Eliminar Producto</span>
                                </Button>
                            </TableCell>
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
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { ProductResource } from '../interface/Product';
import PaginationProduct from '../../../../components/pagination.vue';

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
    productList: ProductResource[];
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

<style scoped>
/* Mejoras específicas para modo oscuro */
.dark .TableHeader {
    background-color: rgba(31, 41, 55, 0.5);
    border-bottom-color: rgba(55, 65, 81, 0.5);
}

/* Transiciones mejoradas */
.TableRow {
    transition:
        background-color 0.15s ease,
        transform 0.1s ease;
}

.TableRow:hover {
    transform: translateY(-1px);
}

/* Estilo para la tabla vacía */
.TableBody:empty::after {
    content: 'No se encontraron productos';
    display: block;
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.dark .TableBody:empty::after {
    color: #9ca3af;
}
</style>
