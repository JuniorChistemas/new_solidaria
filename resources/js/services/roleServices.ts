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
        try {
            await router.post(route('panel.roles.store'), data);
        } catch (error) {
            console.error('Error al crear rol:', error);
            throw error;
        }
    },
    // show roles
    async show(id: number): Promise<showRoleResponse> {
        const response = await axios.get(`/panel/roles/${id}`);
        return response.data;
    },
    // update roles
    async update(id: number, data: RoleUpdateRequest): Promise<showRoleResponse> {
        // Verificar que `data.permisos` sea un array de IDs
        const permisos = Array.isArray(data.permisos) ? data.permisos : [];

        // Convertir explícitamente a un array de IDs si es necesario
        const permisoIds = permisos.map((perm: any) => perm.id || perm);  // Mapear a los IDs si `permisos` son objetos
        
        const response = await axios.put(`/panel/roles/${id}`, {
            name: data.name,
            permisos: permisoIds,  // Enviar solo los IDs de los permisos

        });
        //console.log('Respuesta del servidor:', response.data);
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
