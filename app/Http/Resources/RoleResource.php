<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->timezone('America/Lima')->format('d/m/Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->timezone('America/Lima')->format('d/m/Y H:i:s'),
        ];
    }
}