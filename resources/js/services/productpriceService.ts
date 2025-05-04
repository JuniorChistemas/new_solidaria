import { InputProductResponse } from '@/interface/Inputs';
import {
    ProductpriceDeleteResponse,
    ProductpriceRequest,
    ProductpriceRequestUpdate,
    ProductpriceResponse,
    showProductpriceResponse,
} from '@/pages/panel/product_price/interface/Product_price';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const ProductpriceServices = {
    // list product_precio
    async index(page: number, name: string): Promise<ProductpriceResponse> {
        const response = await axios.get(`/panel/listar-product_prices?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    // inertia
    async store(data: ProductpriceRequest) {
        router.post(route('panel.product_prices.store'), data);
    },
    // show product_precio
    async show(id: number): Promise<showProductpriceResponse> {
        const response = await axios.get(`/panel/product_prices/${id}`);
        return response.data;
    },
    // update product_precio
    async update(id: number, data: ProductpriceRequestUpdate): Promise<showProductpriceResponse> {
        const response = await axios.put(`/panel/product_prices/${id}`, data);
        return response.data;
    },
    async destroy(id: number): Promise<ProductpriceDeleteResponse> {
        return await axios.delete(`/panel/product_prices/${id}`);
    },
    // get Product
    async getProduct(): Promise<InputProductResponse> {
        return await axios.get('/panel/inputs/product_list');
    },
};
