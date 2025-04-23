// @/composables/useUser.ts

import { Pagination } from '@/interface/paginacion';
import { UserResource, UserRequest, UserUpdateRequest } from '@/pages/panel/user/interface/User';
import { UserServices } from '@/services/userServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useUser = () => {
    const principal = reactive<{
        userList: UserResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idUser: number;
        stateModal: {
            update: boolean;
            delete: boolean;
        };
        userData: UserResource;
    }>({
        userList: [],
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
        idUser: 0,
        stateModal: {
            update: false,
            delete: false,
        },
        userData: {
            id: 0,
            name: '',
            email: '',
            state: true,
        },
    });

    // reset user data
    const resetUserData = () => {
        principal.userData = {
            id: 0,
            name: '',
            email: '',
            state: true,
        };
    };

    // loading users
    const loadingUsers = async (page: number = 1, name: string = '', state: boolean = true) => {
        if (state) {
            principal.loading = true;
            try {
                const response = await UserServices.index(page, name);
                principal.userList = response.users;
                principal.paginacion = response.pagination;
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };

    // creating users
    const createUser = async (data: UserRequest) => {
        try {
            await UserServices.store(data);
        } catch (error) {
            console.error(error);
        }
    };

    // get User by id
    const getUserById = async (id: number) => {
        try {
            if (id === 0) {
                resetUserData();
                return;
            }
            const response = await UserServices.show(id);
            if (response.state) {
                principal.userData = response.user;
                principal.idUser = response.user.id;
                principal.stateModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };

    // update user
    const updateUser = async (id: number, data: UserUpdateRequest) => {
        try {
            const response = await UserServices.update(id, data);
            if (response.state) {
                showSuccessMessage('Usuario actualizado', 'El usuario se actualizó correctamente');
                principal.stateModal.update = false;
                loadingUsers(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };

    // delete user
    const deleteUser = async (id: number) => {
        try {
            const response = await UserServices.destroy(id);
            if (response.state) {
                showSuccessMessage('Usuario eliminado', 'El usuario se eliminó correctamente');
                principal.stateModal.delete = false;
                loadingUsers(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.stateModal.delete = false;
        }
    };

    return {
        principal,
        loadingUsers,
        createUser,
        getUserById,
        resetUserData,
        updateUser,
        deleteUser,
    };
};