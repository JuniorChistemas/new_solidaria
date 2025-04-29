import { Pagination } from '@/interface/paginacion';
import { UserRequest, UserResource, UserUpdateRequest } from '@/pages/panel/user/interface/User';
import { userServices } from '@/services/userServices';
import { reactive, ref } from 'vue';

export const useUser = () => {
    const principal = reactive<{
        userList: UserResource[];
        paginacion: Pagination;
        loading: boolean;
        statusModalUpdate: boolean;
        statusModalDelete: boolean;
        user_id_delete: number;
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
        statusModalUpdate: false,
        statusModalDelete: false,
        user_id_delete: 0,
    });

    const user_show = ref<UserResource | null>(null);
    const message = ref<string>('');
    const loadingUser = async (page: number = 1, user: string = '') => {
        try {
            principal.loading = true;
            const response = await userServices.index(page, user);
            principal.userList = response.users;
            principal.paginacion = response.pagination;
        } catch (error) {
            console.error('Error loading users:', error);
        } finally {
            principal.loading = false;
        }
    };
    const storeUser = async (user: UserRequest) => {
        try {
            const response = await userServices.store(user);
            if (response.success) {
                message.value = response.message;
                window.location.href = response.redirect_url;
            }
        } catch (error) {
            console.error('Error storing user:', error);
            message.value = 'Error storing user';
        }
    };
    const showUser = async (id: number) => {
        try {
            const response = await userServices.show(id);
            if (!response.status) {
                user_show.value = null;
                return;
            }
            principal.statusModalUpdate = true;
            user_show.value = response.user;
            message.value = response.message;
        } catch (error) {
            console.error('Error showing user:', error);
            message.value = 'Error showing user';
        }
    };
    const updateUser = async (id: number, user: UserUpdateRequest) => {
        try {
            const response = await userServices.update(id, user);
            if (response.status) {
                message.value = response.message;
                loadingUser(principal.paginacion.current_page);
            }
        } catch (error) {
            console.error('Error updating user:', error);
            message.value = 'Error updating user';
        } finally {
            principal.statusModalUpdate = false;
        }
    };
    const deleteUser = async (id: number) => {
        try {
            const response = await userServices.destroy(id);
            if (response.status) {
                message.value = response.message;
                loadingUser(principal.paginacion.current_page);
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            message.value = 'Error deleting user';
        } finally {
            principal.statusModalDelete = false;
        }
    };
    return {
        principal,
        message,
        user_show,
        loadingUser,
        storeUser,
        showUser,
        updateUser,
        deleteUser,
    };
};
