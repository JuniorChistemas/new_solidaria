import { Pagination } from "@/interface/paginacion";

export type SupplierResource = {
  id: number;
  name: string;
  ruc: string;
  phone: string;
  address: string;
  state: boolean;
};

export type SupplierRequest = {
    name: string;
    ruc: string;
    address: string;
    phone: string;
    state: 'activo' | 'inactivo';
};

export type showSupplierResponse = {
    state: boolean;
    message: string;
    supplier: SupplierResource;
};

export type SupplierDeleteResponse = {
    state: boolean;
    message: string;
};

export type SupplierUpdateRequest = {
    name: string;
    ruc: string;
    address: string;
    phone: string;
    state: 'activo' | 'inactivo';
};
export type SupplierResponse = {
  suppliers: SupplierResource[];
  pagination: Pagination;
};