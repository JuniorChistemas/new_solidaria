import {
    LaboratoryDeleteResponse,
    LaboratoryRequest,
    LaboratoryResponse,
    ShowLaboratoryResponse,
} from '@/pages/panel/laboratory/interface/Laboratory';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const LaboratoryServices = {
    // Listar laboratorios
    async index(page: number, name: string): Promise<LaboratoryResponse> {
        const response = await axios.get(`/panel/listar-laboratories?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },

    // Crear laboratorio (Inertia)
    async store(data: LaboratoryRequest) {
        router.post(route('panel.laboratories.store'), data);
    },

    // Mostrar un laboratorio por ID
    async show(id: number): Promise<ShowLaboratoryResponse> {
        const response = await axios.get(`/panel/laboratories/${id}`);
        return response.data;
    },

    // Actualizar laboratorio
    async update(id: number, data: LaboratoryRequest): Promise<ShowLaboratoryResponse> {
        const response = await axios.put(`/panel/laboratories/${id}`, data);
        return response.data;
    },

    // Eliminar laboratorio
    async destroy(id: number): Promise<LaboratoryDeleteResponse> {
        const response = await axios.delete(`/panel/laboratories/${id}`);
        return response.data;
    },
};
