import { Pagination } from "@/interface/paginacion";

export type CategoryResource = {
  id: number;
  name: string;
  status: boolean;
  created_at: string;
  updated_at: string;
};

export type CategoryRequest = {
    name: string;
    status: 'activo' | 'inactivo';
};

export type showCategoryResponse = {
    status: boolean;
    message: string;
    category: CategoryResource;
};

export type CategoryDeleteResponse = {
    status: boolean;
    message: string;
};

export type CategoryUpdateRequest = {
    name: string;
    status: 'activo' | 'inactivo';
};
export type CategoryResponse = {
  categories: CategoryResource[];
  pagination: Pagination;
};