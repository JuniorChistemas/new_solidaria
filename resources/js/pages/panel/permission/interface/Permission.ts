import { Pagination } from '@/interface/paginacion';

export type PermissionResource = {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
};

export type PermissionRequest = {
    name: string;
};

export type showPermissionResponse = {
    status: boolean;
    message: string;
    permission: PermissionResource;
};

export type PermissionDeleteResponse = {
    status: boolean;
    message: string;
};

export type PermissionUpdateRequest = {
    name: string;
};

export type PermissionResponse = {
    permissions: PermissionResource[];
    pagination: Pagination;
};

export type getPermissionList = {
    id: number;
    name: string;
};
