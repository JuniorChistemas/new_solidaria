import { Pagination } from '@/interface/paginacion';
import { getRoleList, RoleResource, RoleUpdateRequest } from '@/pages/panel/role/interface/Role';
import { RoleServices } from '@/services/roleServices';
import { showErrorMessage, showSuccessMessage } from '@/utils/message';
import { reactive, ref } from 'vue';

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
            permisos: [], 
            created_at: '',
            updated_at: '',
        },
    });
    //reset role data
    const resetroleData = () => {
        principal.roleData = {
            id: 0,
            name: '',
            permisos: [],
            created_at: '',
            updated_at: '',
        };
    };

    const roles = ref<getRoleList[]>([]);

    // loading roles
    const loadingRoles = async (page: number = 1, name: string = '') => {
        principal.loading = true;
        try {
            const response = await RoleServices.index(page, name);
            principal.roleList = response.roles;
            principal.paginacion = response.pagination;
            console.log('Roles cargados:',response);
        } catch (error) {
            console.error(error);
            showErrorMessage('Error al cargar los roles', 'Hubo un problema al obtener los roles.');
        } finally {
            principal.loading = false;
        }
    };
    // creating roles
    const createRole = async (data: { name: string }) => {
        try {
            await RoleServices.store(data); // Incluimos un id predeterminado
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
                    permisos: [],
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
            showErrorMessage('Error al obtener el rol', 'Hubo un problema al obtener los datos del rol.');
        }
    };
    // update role
    const updateRole = async (id: number, data: RoleUpdateRequest) => {
        try {
            await RoleServices.update(id, data);
        } catch (error) {
            console.error(error);
            showErrorMessage('Error al actualizar el rol', 'Hubo un problema al actualizar el rol.');
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
            showErrorMessage('Error al eliminar el rol', 'Hubo un problema al eliminar el rol.');
        } finally {
            principal.statusModal.delete = false;
        }
    };
    // GET ROLES
    const getRoles = async () => {
        try {
            const response = await RoleServices.getRoles();
            roles.value = response;
        } catch (error) {
            console.error(error);
        }
    };
    return {
        principal,
        roles,
        loadingRoles,
        createRole,
        getRoleById,
        resetroleData,
        updateRole,
        deleteRole,
        getRoles,
    };
};
