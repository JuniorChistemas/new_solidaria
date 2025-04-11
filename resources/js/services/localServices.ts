import {
    LocalDeleteResponse,
    LocalRequest,
    LocalResponse,
    LocalUpdateRequest,
    showLocalResponse,
} from '@/pages/panel/local/interface/Local';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const localServices = {
    //list locals
    async index(page: number, name: string): Promise<LocalResponse> {
        const response = await axios.get(`/panel/listar-locals?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: LocalRequest) {
        router.post(route('panel.locals.store'), data);
    },
    // show locals
    async show(id: number): Promise<showLocalResponse> {
        const response = await axios.get(`locals/${id}`);
        return response.data;
    },
    // update locals
    async update(id: number, data: LocalUpdateRequest): Promise<showLocalResponse> {
        const response = await axios.put(`locals/${id}`, data);
        return response.data;
    },
    // detele locals
    async destroy(id: number): Promise<LocalDeleteResponse> {
        const response = await axios.delete(`locals/${id}`);
        return response.data;
    },
};
