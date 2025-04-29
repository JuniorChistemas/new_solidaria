import { InventoryResponse, showInventoryResponse } from '@/pages/panel/inventory/partials/interface/Inventory';
import axios from 'axios';

export const inventoryService = {
    /**
     * Listar inventario con paginación y filtros
     * @param params Parámetros de paginación y filtrado
     */
    async getInventory(params: { page: number, name: string }): Promise<InventoryResponse> {
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
