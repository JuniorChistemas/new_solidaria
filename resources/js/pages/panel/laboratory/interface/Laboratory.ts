import { Pagination } from '@/interface/paginacion';

export type LaboratoryResource = {
    id: number;
    name: string;
    state: boolean;
    created_at?: string; //FECHA DE CREACION
    updated_at?: string; //FECHA DE MODIFIACION
};

export type LaboratoryRequest = {
    name: string;
    state: boolean;
};

export type LaboratoryUpdateRequest = {
    name: string;
    state: boolean;
};

export type ShowLaboratoryResponse = {
    state: boolean;
    message: string;
    laboratory: LaboratoryResource;
};

export type LaboratoryDeleteResponse = {
    state: boolean;
    message: string;
};

export type LaboratoryResponse = {
    laboratories: LaboratoryResource[];
    pagination: Pagination;
};
