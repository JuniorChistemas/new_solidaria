// @/pages/panel/user/interface/User.ts

import { Pagination } from '@/interface/paginacion';

export interface UserResource {
    id: number;
    name: string;
    username: string;
    local: string;
    email: string;
    status: boolean;
    created_at: string;
    role: string;
}

export interface getUserResponse {
    id: number;
    name: string;
    email: string;
}

export interface UserRequest {
    name: string;
    email: string;
    username: string;
    local_id: number;
    password: string;
    status: boolean;
    role_name: string;
}

export interface UserResponseStore {
    success: boolean;
    message: string;
    redirect_url: string;
    user: UserResource;
}

export interface UserUpdateRequest {
    name: string;
    email: string;
    username: string;
    local_id: number | null;
    password: string | null;
    status: boolean;
    role_name: string | null;
}

export interface UserResponse {
    users: UserResource[];
    pagination: Pagination;
}

export interface showUserResponse {
    status: boolean;
    message: string;
    user: UserResource;
}

export interface UserDeleteResponse {
    status: boolean;
    message: string;
}
