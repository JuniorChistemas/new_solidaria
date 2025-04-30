import { Pagination } from "@/interface/paginacion";


export interface InventoryResource {
    id: number;
    nombre: string;
    composicion: string;
    presentacion: string;
    laboratorio: string;
    categoria: string;
    cajas: number;
    fracciones: number;
}

export interface InventoryResponse {
    data: InventoryResource[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };
    meta: Pagination;
}

export interface showInventoryResponse {
    state: boolean;
    message: string;
    product: InventoryResource;
}