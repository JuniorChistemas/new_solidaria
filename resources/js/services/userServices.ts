// @/services/userServices.ts

import { showUserResponse, UserDeleteResponse, UserRequest, UserResponse, UserUpdateRequest } from "@/pages/panel/user/interface/User";
import { router } from '@inertiajs/vue3';
import axios from "axios";

export const UserServices = {
    // list users
    async index(page: number, name: string): Promise<UserResponse> {
        const response = await axios.get(`/panel/listar-users?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    
    // create user with inertia
    async store(data: UserRequest) {
        router.post(route('panel.users.store'), data);
    },
    
    // show user
    async show(id: number): Promise<showUserResponse> {
        const response = await axios.get(`/panel/users/${id}`);
        return response.data;
    },
    
    // update user
    async update(id: number, data: UserUpdateRequest): Promise<showUserResponse> {
        const response = await axios.put(`/panel/users/${id}`, data);
        return response.data;
    },
    
    // delete user
    async destroy(id: number): Promise<UserDeleteResponse> {
        const response = await axios.delete(`/panel/users/${id}`);
        return response.data;
    },
    
    // get users for dropdown/combobox
    async getUsers(search: string = ''): Promise<UserResource[]> {
        const response = await axios.get(`/panel/inputs/users${search ? `?search=${encodeURIComponent(search)}` : ''}`);
        return response.data;
    },
};