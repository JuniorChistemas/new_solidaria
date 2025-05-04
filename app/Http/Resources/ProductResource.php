<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'composition' => $this->composition,
            'presentation'=> $this->presentation,
            'form_farm'=> $this->form_farm,
            'barcode' => $this->barcode,
            'laboratory_id'=> $this->laboratory->id,
            'laboratory'=> $this->laboratory->name,
            'category_id'=> $this->category->id,
            'category'=> $this->category->name,
            'fraction' => $this->fraction,
            'state_fraction'=> $this->state_fraction,
            'state_igv'=> $this->state_igv,
            'state'=> $this->state,
        ];
    }
}
