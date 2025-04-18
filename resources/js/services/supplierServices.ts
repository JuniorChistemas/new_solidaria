import { showSupplierResponse, SupplierDeleteResponse, SupplierRequest, SupplierResponse, SupplierUpdateRequest } from "@/pages/panel/supplier/interface/Supplier";
import { router } from '@inertiajs/vue3';
import axios from "axios";


export const SupplierServices = {

    //list suppliers
    async index(page: number, name: string): Promise<SupplierResponse> {
        const response = await axios.get(`/panel/listar-suppliers?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: SupplierRequest)  {
        router.post(route('panel.suppliers.store'), data);
    },
    // show supplier
    async show(id: number): Promise<showSupplierResponse> {
        const response = await axios.get(`/panel/suppliers/${id}`);
        return response.data;
    },
    // update supplier
    async update(id: number, data: SupplierUpdateRequest): Promise<showSupplierResponse> {
        const response = await axios.put(`/panel/suppliers/${id}`, data);
        return response.data;
    },
    // detele supplier
    async destroy(id: number): Promise<SupplierDeleteResponse> {
        const response = await axios.delete(`/panel/suppliers/${id}`);
        return response.data;
    },
    async getSuppliers(search: string = ''): Promise<SupplierResponse> {
        const response = await axios.get(`/panel/inputs/suppliers${search ? `?search=${encodeURIComponent(search)}` : ''}`);
        return response.data;
    },
};