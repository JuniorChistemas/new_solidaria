<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'fechaEmision' => $this->fechaEmision,
            'fechaEjecucion' => $this->fechaEjecucion,
            'fechaCredito' => $this->fechaCredito,
            'idProveedor' => $this->idProveedor,
            'idLocal' => $this->idLocal,
            'idUser' => $this->idUser,
            'idTipoMovimiento' => $this->idTipoMovimiento,
            'tipoMovimientoTexto' => match ($this->idTipoMovimiento) {
                1 =>'Factura',
                2 =>'Guia',
                3=>'Boleta',
                4=>'Venta',
                default => 'Desconocido',
            },
            'estado' => $this->estado,
           'estadoTexto' => match ($this->estado) {
                0 => 'Eliminado',
                1 => 'Activo',
                2=> 'Anulado',
                default => 'Desconocido',
            },
            'estadoIgv' => $this->estadoIgv,
            'estadoIngreso' => $this->estadoIngreso,
            'tipoPago' => $this->tipoPago,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // You might want to include relationships
            'supplier' => $this->whenLoaded('supplier'),
            'local' => $this->whenLoaded('local'),
            'user' => $this->whenLoaded('user'),
        ];
    }

    
}