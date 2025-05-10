<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSale extends Pivot
{
    protected $table = 'product_sale';

    protected $fillable = [
        'sale_id',
        'product_local_id',
        'quantity_box',
        'quantity_fraccion',
        'price_box',
        'price_fraccion',
    ];
}
