import { Pagination } from '@/interface/paginacion';

export type RoleResource = {
    id: number;
    name: string;
    permisos: RoleRequest[];
    created_at: string;
    updated_at: string;
};

export type RoleRequest = {
    id?: number;
    name: string;
};

export type showRoleResponse = {
    status: boolean;
    message: string;
    role: RoleResource;
};

export type RoleDeleteResponse = {
    status: boolean;
    message: string;
};

export type RoleUpdateRequest = {
    id?: number;
    name: string;
    permisos: number[];
};

export type RoleResponse = {
    roles: RoleResource[];
    permisos: RoleRequest[];
    pagination: Pagination;
};

export type getRoleList = {
    id: number;
    name: string;
};
