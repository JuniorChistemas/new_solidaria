import { Pagination } from "@/interface/paginacion";

export type ZoneResource = {
  id: number;
  name: string;
  status: boolean;
  created_at: string;
  updated_at: string;
};

export type ZoneRequest = {
    name: string;
    status: 'activo' | 'inactivo';
};

export type showZoneResponse = {
    status: boolean;
    message: string;
    zone: ZoneResource;
};

export type ZoneDeleteResponse = {
    status: boolean;
    message: string;
};

export type ZoneUpdateRequest = {
    name: string;
    status: 'activo' | 'inactivo';
};
export type ZoneResponse = {
  zones: ZoneResource[];
  pagination: Pagination;
};