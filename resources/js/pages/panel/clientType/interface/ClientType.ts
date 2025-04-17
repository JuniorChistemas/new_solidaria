import { Pagination } from "@/interface/paginacion";

export type ClientTypeResource = {
  id: number;
  name: string;
  state: boolean;
  created_at: string;
  updated_at: string;
};

export type ClientTypeRequest = {
  name: string;
  state: 'activo' | 'inactivo';
};

export type showClientTypeResponse = {
  status: boolean;
  message: string;
  clientType: ClientTypeResource;
};

export type ClientTypeDeleteResponse = {
  status: boolean;
  message: string;
};

export type ClientTypeUpdateRequest = {
  name: string;
  state: 'activo' | 'inactivo';
};

export type ClientTypeResponse = {
  clientTypes: ClientTypeResource[];
  pagination: Pagination;
};