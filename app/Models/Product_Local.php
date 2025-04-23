<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product_Local extends Model
{
    use HasFactory;

    protected $table = 'product_locals';
    protected $fillable = [
        'product_id',
        'local_id',
        'StockFraction',
        'StockBox',
        'stock_min',
        'stock_max',
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function local(): BelongsTo{
        return $this->belongsTo(Local::class,'local_id','id');
    }
}
