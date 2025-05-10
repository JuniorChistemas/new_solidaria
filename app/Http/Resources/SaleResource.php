<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'usuario' => $this->user->name,
            'cliente' => $this->customer->firstname . ' ' . $this->customer->lastname,
            'local' => $this->local->name,
            'doctor' => $this->doctor->name ?? 'sin doctor',
            'tipo_comprobante' => $this->typeVoucher->name,
            'tipo_pago' => $this->typePayment->name,
            'codigo' => $this->code,
            'codigo_tarjeta' => $this->code_card ?? 'sin codigo',
            'op_gravada' => $this->op_gravada,
            'op_exonerada' => $this->op_exonerada,
            'op_inafecta' => $this->op_inafecta,
            'igv' => $this->igv,
            'total' => $this->total,
            'estado_venta' => $this->status_sale,
            'estado_sunat' => $this->state_sunat,
            'created_at' => $this->created_at,
        ];
    }
}
