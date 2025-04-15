// @/pages/panel/user/interface/User.ts

import { Pagination } from '@/interface/paginacion';

export interface UserResource {
    id: number;
    name: string;
    email: string;
    state: boolean;
}

export interface UserRequest {
    name: string;
    email: string;
    password: string;
    state: boolean;
}

export interface UserUpdateRequest {
    name: string;
    email: string;
    state: boolean;
    password?: string;
}

export interface UserResponse {
    users: UserResource[];
    pagination: Pagination;
}

export interface showUserResponse {
    user: UserResource;
    state: boolean;
}

export interface UserDeleteResponse {
    state: boolean;
    message: string;
}