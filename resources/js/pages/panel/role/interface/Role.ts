import { Pagination } from "@/interface/paginacion";

export type RoleResource = {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
};

export type RoleRequest = {
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
    name: string;
};

export type RoleResponse = {
  roles: RoleResource[];
  pagination: Pagination;
};