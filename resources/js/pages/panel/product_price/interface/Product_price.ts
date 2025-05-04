import { Pagination } from '@/interface/paginacion';

export type ProductpriceResource = {
    id: number;
    product_id: number;
    product: string;
    box_price: number;
    fraction_price: number;
};

export type ProductpriceRequest = {
    product_id: number;
    product: string;
    box_price: number;
    fraction_price: number;
};

export type ProductpriceRequestUpdate = {
    product_id: number;
    box_price: number;
    fraction_price: number;
};

export type showProductpriceResponse = {
    message: string;
    productprice: ProductpriceResource;
};

export type ProductpriceDeleteResponse = {
    message: string;
};

export type ProductpriceResponse = {
    productsprice: ProductpriceResource[];
    pagination: Pagination;
};
