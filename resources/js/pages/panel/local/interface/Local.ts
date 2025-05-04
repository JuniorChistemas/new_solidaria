import { Pagination } from '@/interface/paginacion';

export type LocalResource = {
    id: number;
    name: string;
    address: string;
    series: string;
    series_note?: string;
    status: boolean;
    created_at: string;
    updated_at: string;
};

export type LocalRequest = {
    name: string;
    address: string;
    series: string;
    series_note?: string;
    status: 'activo' | 'inactivo';
};

export type showLocalResponse = {
    status: boolean;
    message: string;
    local: LocalResource;
};

export type LocalDeleteResponse = {
    status: boolean;
    message: string;
};

export type LocalUpdateRequest = {
    name: string;
    address: string;
    series: string;
    series_note?: string;
    status: 'activo' | 'inactivo';
};

export type LocalResponse = {
    locals: LocalResource[];
    pagination: Pagination;
};

export type GetLocalResponse = {
    id: number;
    name: string;
};
