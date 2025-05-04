// @/interface/Inputs.ts
export interface InputSupplier {
    id: number;
    name: string;
    ruc?: string;
    phone?: string;
    address?: string;
    state?: boolean;
}

export interface InputSupplierResponse {
    data: InputSupplier[];
}

// Puedes añadir otras interfaces relacionadas aquí
export interface InputLaboratory {
    id: number;
    name: string;
}

export interface InputLaboratoryResponse {
    data: InputLaboratory[];
}

export interface InputCategory {
    id: number;
    name: string;
}

export interface InputCategoryResponse {
    data: InputCategory[];
}

export interface InputProduct {
    id: number;
    name: string;
}
export interface InputProductResponse {
    data: InputProduct[];
}

export interface InputUser {
    id: number;
    name: string;
}

export interface InputUserResponse {
    data: InputUser[];
}

export interface InputMovementType {
    id: number;
    nombre: string;
}

export interface InputMovementTypeResponse {
    data: InputMovementType[];
}