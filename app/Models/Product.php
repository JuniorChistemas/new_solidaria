<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

        # Tabla
        protected $fillable = [
        'name',
        'composition',
        'presentation',
        'form_farm',
        'barcode',
        'laboratory_id',
        'category_id',
        'state_fraction',
        'state_igv',
        'state',
    ];
    protected $casts = [
        'state_fraction' => 'boolean',
        'state_igv' => 'boolean',
        'state' => 'boolean',
    ];


    public function laboratory(): BelongsTo{
        return $this->belongsTo(Laboratory::class,'laboratory_id','id');
    }
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
