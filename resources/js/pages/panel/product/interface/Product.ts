import { Pagination } from '@/interface/paginacion';

export type ProductResource = {
    id: number;
    name: string;
    composition: string;
    presentation: string;
    form_farm: string;
    barcode: string;
    laboratory_id: number;
    laboratory: string;
    category_id: number;
    category: string;
    fraction: number;
    state_fraction: boolean;
    state_igv: boolean;
    state: boolean;
};

export type ProductRequest = {
    name: string;
    composition: string;
    presentation: string;
    form_farm: string;
    barcode: string;
    fraction: number;
    laboratory_id: number;
    category_id: number;
};

export type ProductRequestUpdate = {
    name: string;
    composition: string;
    presentation: string;
    form_farm: string;
    barcode: string;
    laboratory_id: number;
    category_id: number;
    fraction: number;
    state_fraction: boolean;
    state_igv: boolean;
    state: boolean;
};

export type showProductResponse = {
    status: boolean;
    message: string;
    product: ProductResource;
};

export type ProductDeleteResponse = {
    status: boolean;
    message: string;
};

export type ProductResponse = {
    products: ProductResource[];
    pagination: Pagination;
};
