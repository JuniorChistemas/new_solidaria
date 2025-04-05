import {
    ClientTypeDeleteResponse,
    ClientTypeRequest,
    ClientTypeResponse,
    showClientTypeResponse,
} from '@/pages/panel/clientType/interface/ClientType';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const ClientTypeServices = {
    //List clientTypes
    async index(page: number, name: string): Promise<ClientTypeResponse> {
        const response = await axios.get(`/panel/listar-clientTypes?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },

    //Inertia
    async store(data: ClientTypeRequest) {
        router.post(route('panel.clientTypes.store'), data);
    },

    //Show clientType
    async show(id: number): Promise<showClientTypeResponse> {
        const response = await axios.get(`/panel/clientTypes/${id}`);
        return response.data;
    },

    //Update clientType
    async update(id: number, data: ClientTypeRequest): Promise<showClientTypeResponse> {
        const response = await axios.put(`/panel/clientTypes/${id}`, data);
        return response.data;
    },

    //Delete clientType
    async destroy(id: number): Promise<ClientTypeDeleteResponse> {
        const response = await axios.delete(`/panel/clientTypes/${id}`);
        return response.data;
    },
};