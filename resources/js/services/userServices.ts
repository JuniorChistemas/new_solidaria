import {
    getUserResponse,
    showUserResponse,
    UserDeleteResponse,
    UserRequest,
    UserResponse,
    UserResponseStore,
    UserUpdateRequest,
} from '@/pages/panel/user/interface/User';
import axios from 'axios';
export const userServices = {
    async getUsers(search: string = ''): Promise<getUserResponse[]> {
        const response = await axios.get(`/panel/inputs/users${search ? `?search=${encodeURIComponent(search)}` : ''}`);
        return response.data;
    },
    async index(page: number, user: string): Promise<UserResponse> {
        const response = await axios.get(`/panel/listar-users?page=${page}&name=${encodeURIComponent(user)}`);
        return response.data;
    },
    async store(user: UserRequest): Promise<UserResponseStore> {
        const response = await axios.post('/panel/users', user);
        return response.data;
    },
    async show(id: number): Promise<showUserResponse> {
        const response = await axios.get(`/panel/users/${id}`);
        return response.data;
    },
    async update(id: number, user: UserUpdateRequest): Promise<showUserResponse> {
        const response = await axios.put(`/panel/users/${id}`, user);
        return response.data;
    },
    async destroy(id: number): Promise<UserDeleteResponse> {
        const response = await axios.delete(`/panel/users/${id}`);
        return response.data;
    },
};
