<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? '000',
            'code' => $this->code,
            'type_movement' => $this->typeMovements->name,
            'origin_local' => $this->originLocals->name,
            'destination_local' => $this->destinationLocals->name,
            'sent_at' => $this->sent_at,
            'status' => $this->status,
        ];
    }
}
