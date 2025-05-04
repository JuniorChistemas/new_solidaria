import { getRoleList, RoleDeleteResponse, RoleRequest, RoleResponse, RoleUpdateRequest, showRoleResponse } from '@/pages/panel/role/interface/Role';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const RoleServices = {
    //list roles
    async index(page: number, name: string): Promise<RoleResponse> {
        const response = await axios.get(`/panel/listar-roles?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: RoleRequest) {
        router.post(route('panel.roles.store'), data);
    },
    // show roles
    async show(id: number): Promise<showRoleResponse> {
        const response = await axios.get(`roles/${id}`);
        return response.data;
    },
    // update roles
    async update(id: number, data: RoleUpdateRequest): Promise<showRoleResponse> {
        const response = await axios.put(`roles/${id}`, data);
        return response.data;
    },
    // detele roles
    async destroy(id: number): Promise<RoleDeleteResponse> {
        const response = await axios.delete(`roles/${id}`);
        return response.data;
    },
    // get roles
    async getRoles(): Promise<getRoleList[]> {
        const response = await axios.get('/panel/inputs/role_list');
        return response.data;
    },
};
