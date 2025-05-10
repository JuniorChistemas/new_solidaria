<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class guide_products extends Pivot
{
    protected $table = 'guide_products';

    protected $fillable = [
        'guide_id',
        'product_local_id',
        'quantity_box',
        'quantity_fraction',
    ];

    public $timestamps = true;
}
