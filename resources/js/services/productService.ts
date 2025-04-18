import { InputLaboratoryResponse } from '@/interface/Inputs';
import { InputCategoryResponse } from '@/interface/Inputs';
import {
    ProductDeleteResponse,
    ProductRequest,
    ProductRequestUpdate,
    ProductResponse,
    showProductResponse,
} from '@/pages/panel/product/interface/Product';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const ProductServices = {
    // list products
    async index(page: number, name: string): Promise<ProductResponse> {
        const response = await axios.get(`/panel/listar-products?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    // inertia
    async store(data: ProductRequest) {
        router.post(route('panel.products.store'), data);
    },
    // show product
    async show(id: number): Promise<showProductResponse> {
        const response = await axios.get(`/panel/products/${id}`);
        return response.data;
    },
    // update product
    async update(id: number, data: ProductRequestUpdate): Promise<showProductResponse> {
        const response = await axios.put(`/panel/products/${id}`, data);
        return response.data;
    },
    async destroy(id: number): Promise<ProductDeleteResponse> {
        return await axios.delete(`/panel/products/${id}`);
    },
    // get Laboratory
    async getLaboratory(): Promise<InputLaboratoryResponse> {
        return await axios.get('/panel/inputs/laboratory_list');
    },
        // get Category
        async getCategory(): Promise<InputCategoryResponse> {
            return await axios.get('/panel/inputs/category_list');
        },
};
