
import { Pagination } from '@/interface/paginacion';
import { RoleRequest, RoleResource, RoleUpdateRequest } from '@/pages/panel/role/interface/Role';
import { RoleServices } from '@/services/roleServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useRole = () => {
    const principal = reactive<{
        roleList: RoleResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idRole: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        roleData: RoleResource;
    }>({
        roleList: [],
        paginacion: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
        },
        loading: false,
        filter: '',
        idRole: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        roleData: {
            id: 0,
            name: '',
            created_at: '',
            updated_at: '',
        },
    });
        //reset role data
        const resetroleData = () => {
            principal.roleData = {
                id: 0,
                name: '',
                created_at: '',
                updated_at: '',
            };
        };

    // loading roles
    const loadingRoles = async (page: number = 1, name: string = '') => {
        principal.loading = true;
        try {
            const response = await RoleServices.index(page, name);
            principal.roleList = response.roles;
            principal.paginacion = response.pagination;
            console.log(response);
        } catch (error) {
            console.error(error);
        } finally {
            principal.loading = false;
        }
    };
            // creating roles
            const createRole = async (data: { name: string; permisos: number[] }) => {
                try {
                    await RoleServices.store(data);  // Aquí estamos enviando el rol con sus permisos
                } catch (error) {
                    console.error(error);
                }
            };
        // get role by id
        const getRoleById = async (id: number) => {
            try {
                if (id === 0) {
                    principal.roleData = {
                        id: 0,
                        name: '',
                        created_at: '',
                        updated_at: '',
                    };
                    return;
                }
            const response = await RoleServices.show(id);
            if (response.status) {
                principal.roleData = response.role;
                console.log(principal.roleData.name);
                principal.idRole = response.role.id;
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };
    // update role
    const updateRole = async (id: number, data: RoleUpdateRequest) => {
        try {
            const response = await RoleServices.update(id, data);
            if (response.status) {
                showSuccessMessage('Rol actualizado', 'El rol se actualizó correctamente');
                principal.statusModal.update = false;
                loadingRoles(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };
    // delete role
    const deleteRole = async (id: number) => {
        try {
            const response = await RoleServices.destroy(id);
            console.log(response.status);
            if (response.status) {
                showSuccessMessage('Rol eliminado', 'El rol se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingRoles(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };
    return {
        principal,
        loadingRoles,
        createRole,
        getRoleById,
        resetroleData,
        updateRole,
        deleteRole,
    };
};