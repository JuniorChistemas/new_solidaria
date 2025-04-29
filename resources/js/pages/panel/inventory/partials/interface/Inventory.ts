import { Pagination } from "@/interface/paginacion";

/**
 * Estructura de un producto en el inventario
 */
export type InventoryResource = {
    id: number;
    nombre: string;
    composicion: string;
    presentacion: string;
    laboratorio: string;
    categoria: string;
    cajas: string | number;
    fracciones: string | number;
};

/**
 * Respuesta de la API al solicitar un producto específico
 */
export type showInventoryResponse = {
    state: boolean;
    message: string;
    product: InventoryResource;
};

/**
 * Respuesta de la API al listar productos
 */
export type InventoryResponse = {
    data: InventoryResource[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };
    meta: Pagination;
};