import { InventoryResponse, showInventoryResponse } from '@/pages/panel/inventory/partials/interface/Inventory';
import axios from 'axios';

export interface FilterParams {
    page: number;
    per_page?: number;
    nombre?: string;
    estadoStock?: string;
    localId?: number | null;
    laboratorioId?: number | null;
    categoriaId?: number | null;
}

export const inventoryService = {
    /**
     * Listar inventario con paginación y filtros
     * @param params Parámetros de paginación y filtrado
     */
    async getInventory(params: FilterParams): Promise<InventoryResponse> {
        const response = await axios.get('/panel/listar-inventory', { params });
        return response.data;
    },
    
    /**
     * Obtener detalles de un producto específico por ID
     * @param id ID del producto
     */
    async getProductById(id: number): Promise<showInventoryResponse> {
        const response = await axios.get(`/panel/products/${id}`);
        return response.data;
    }
};