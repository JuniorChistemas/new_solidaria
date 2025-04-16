<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product_Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'zone_id',
        'purchase_price',
        'percentage',
        'unit_price',
        'fraction_price',
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function local(): BelongsTo{
        return $this->belongsTo(Local::class,'local_id','id');
    }
}
