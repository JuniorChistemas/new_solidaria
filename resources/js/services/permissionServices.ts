import {
    getPermissionList,
    PermissionDeleteResponse,
    PermissionRequest,
    PermissionResponse,
    PermissionUpdateRequest,
    showPermissionResponse,
} from '@/pages/panel/permission/interface/Permission';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const PermissionServices = {
    // List permissions
    async index(page: number, name: string): Promise<PermissionResponse> {
        const response = await axios.get(`/panel/listar-permissions?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },

    // Create permission using Inertia
    async store(data: PermissionRequest) {
        router.post(route('panel.permissions.store'), data);
    },

    // Show specific permission
    async show(id: number): Promise<showPermissionResponse> {
        const response = await axios.get(`permissions/${id}`);
        return response.data;
    },

    // Update permission
    async update(id: number, data: PermissionUpdateRequest): Promise<showPermissionResponse> {
        const response = await axios.put(`permissions/${id}`, data);
        return response.data;
    },

    // Delete permission
    async destroy(id: number): Promise<PermissionDeleteResponse> {
        const response = await axios.delete(`permissions/${id}`);
        return response.data;
    },

    // Get all permissions for dropdown/selects
    async getPermissions(): Promise<getPermissionList[]> {
        const response = await axios.get('/panel/inputs/permission_list');
        return response.data;
    },
};
