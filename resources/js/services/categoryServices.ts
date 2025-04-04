import { CategoryDeleteResponse, CategoryRequest, CategoryResponse, CategoryUpdateRequest, showCategoryResponse } from "@/pages/panel/category/interface/Category";
import { router } from '@inertiajs/vue3';
import axios from "axios";


export const CategoryServices = {

    //list categories
    async index(page: number, name: string): Promise<CategoryResponse> {
        const response = await axios.get(`/panel/listar-categories?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: CategoryRequest)  {
        router.post(route('panel.categories.store'), data);
    },
    // show categories
    async show(id: number): Promise<showCategoryResponse> {
        const response = await axios.get(`categories/${id}`);
        return response.data;
    },
    // update categories
    async update(id: number, data: CategoryUpdateRequest): Promise<showCategoryResponse> {
        const response = await axios.put(`categories/${id}`, data);
        return response.data;
    },
    // detele categories
    async destroy(id: number): Promise<CategoryDeleteResponse> {
        const response = await axios.delete(`categories/${id}`);
        return response.data;
    },
};