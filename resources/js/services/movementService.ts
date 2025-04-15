// movementService.ts
import {
    MovementDeleteResponse,
    MovementRequest,
    MovementResponse,
    showMovementResponse,
} from '@/pages/panel/movement/interface/Movement';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const MovementServices = {
    //List Movement
    async index(page: number, codigo: string): Promise<MovementResponse> {
        const response = await axios.get(`/panel/listar-movements?page=${page}&codigo=${encodeURIComponent(codigo)}`);
        return response.data;
    },

    //Inertia
    async store(data: MovementRequest) {
        router.post(route('panel.movements.store'), data);
    },

    //Show Movement
    async show(id: number): Promise<showMovementResponse> {
        const response = await axios.get(`/panel/movements/${id}`);
        return response.data;
    },

    //Update Movement
    async update(id: number, data: MovementRequest): Promise<showMovementResponse> {
        const response = await axios.put(`/panel/movements/${id}`, data);
        return response.data;
    },

    //Delete Movement
    async destroy(id: number): Promise<MovementDeleteResponse> {
        const response = await axios.delete(`/panel/movements/${id}`);
        return response.data;
    },
};