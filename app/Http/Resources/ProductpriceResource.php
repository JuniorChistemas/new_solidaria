<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this -> id,
            'product_id' => $this->product? $this->product->id: 0,
            'product' => $this->product? $this->product->name: 'nada',
            'box_price' => $this->box_price,
            'fraction_price' => $this->fraction_price,
        ];
    }
}
