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
            'code' => $this->code,
            'issue_date' => $this->issue_date,
            'credit_date' => $this->credit_date,
            'supplier_id' => $this->supplier_id,
            'supplier_name' => $this->supplier ? $this->supplier->name : null,
            'user_id' => $this->user_id,
            'user_name' => $this->user ? $this->user->name : null,
            'type_movement_id' => $this->type_movement_id,
            'status' => $this->status,
            'statustext' => match ($this->status) {
                0 => 'Eliminado',
                1 => 'Activo',
                2=> 'Anulado',
                default => 'Desconocido',
            },
            'igv_status' => $this->igv_status,
            'payment_type' => $this->payment_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // You might want to include relationships
            'supplier' => $this->whenLoaded('supplier'),
            'user' => $this->whenLoaded('user'),
            'typemovement' => $this->whenLoaded('typemovement'),
        ];
    }

    
}