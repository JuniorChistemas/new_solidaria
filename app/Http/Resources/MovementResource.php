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
            'fechaCredito' => $this->fechaCredito,
            'idProveedor' => $this->idProveedor,
            'idUser' => $this->idUser,
            'idTipoMovimiento' => $this->idTipoMovimiento,
            'estado' => $this->estado,
           'estadoTexto' => match ($this->estado) {
                0 => 'Eliminado',
                1 => 'Activo',
                2=> 'Anulado',
                default => 'Desconocido',
            },
            'estadoIgv' => $this->estadoIgv,
            'tipoPago' => $this->tipoPago,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // You might want to include relationships
            'supplier' => $this->whenLoaded('supplier'),
            'local' => $this->whenLoaded('local'),
            'user' => $this->whenLoaded('user'),
            'typemovement' => $this->whenLoaded('typemovement'),
        ];
    }

    
}