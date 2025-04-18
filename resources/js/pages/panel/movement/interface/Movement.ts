// Movements.ts
import { Pagination } from "@/interface/paginacion";

export type MovementResource {
  id: number;
  codigo: string;
  fechaEmision: string;
  fechaCredito: string;
  idProveedor: number;
  idUser: number;
  idTipoMovimiento: number;
  tipoMovimientoTexto: string;
  estado: number;
  estadoTexto: string;
  estadoIgv: number;
  tipoPago: string;
  created_at: string;
  updated_at: string;
  supplier?: {
      id: number;
      name: string; // Add other supplier details here
  };
  local?: {
      id: number;
      name: string; // Add other local details here
  };
  user?: {
      id: number;
      name: string; // Add other user details here
  };
}

export type MovementRequest = {
  codigo: string;
  fechaEmision: string;
  fechaCredito?: string;
  idProveedor: number;
  idUser: number;
  idTipoMovimiento: number;
  estado: number;
  estadoIgv: number;
  tipoPago: string;
};

export type showMovementResponse = {
  state: boolean;
  message: string;
  movement: MovementResource;
};

export type MovementDeleteResponse = {
  state: boolean;
  message: string;
};

export type MovementUpdateRequest = {
  codigo?: string;
  fechaEmision?: string;
  fechaCredito?: string;
  idProveedor?: number;
  idUser?: number;
  idTipoMovimiento?: number;
  estado?: number;
  estadoIgv?: number;
  tipoPago?: string;
};

export type MovementResponse = {
  movements: MovementResource[];
  pagination: Pagination;
};