import { reactive } from 'vue';
import { inventoryService, FilterParams } from '../services/inventoryService';
import { Pagination } from '@/interface/paginacion';
import { InventoryResource } from '@/pages/panel/inventory/partials/interface/Inventory';

export function useInventory() {
    const principal = reactive({
        productList: [] as InventoryResource[],
        paginacion: {} as Pagination,
        loading: false,
        error: null as string | null,
    });

    /**
     * Carga la lista de productos con paginación y filtros opcionales
     * @param page Número de página
     * @param filters Parámetros de filtrado
     */
    const loadingProducts = async (page = 1, filters: Partial<FilterParams> = {}) => {
        try {
            principal.loading = true;
            
            const params: FilterParams = {
                page,
                per_page: 10,
                nombre: filters.nombre || '',
                estadoStock: filters.estadoStock || '3',
                localId: filters.localId || null,
                laboratorioId: filters.laboratorioId || null,
                categoriaId: filters.categoriaId || null,
                ...filters
            };
            
            const response = await inventoryService.getInventory(params);
            
            principal.productList = response.data;
            principal.paginacion = response.meta;
        } catch (error) {
            console.error('Error cargando los productos:', error);
            principal.error = 'Error al cargar los productos';
        } finally {
            principal.loading = false;
        }
    };

    /**
     * Obtiene un producto específico por su ID
     * @param id ID del producto
     */
    const getProductById = async (id: number) => {
        try {
            principal.loading = true;
            const response = await inventoryService.getProductById(id);
            return response.product;
        } catch (error) {
            console.error(`Error obteniendo el producto con ID ${id}:`, error);
            principal.error = 'Error al obtener el producto';
            return null;
        } finally {
            principal.loading = false;
        }
    };

    return {
        principal,
        loadingProducts,
        getProductById
    };
}