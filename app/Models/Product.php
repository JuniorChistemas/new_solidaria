<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'fraction',
        'state_fraction',
        'state_igv',
        'state',
    ];
    protected $casts = [
        'state_fraction' => 'boolean',
        'state_igv' => 'boolean',
        'state' => 'boolean',
    ];


    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'product_zone');
    }

    // Añadir la relación faltante product_locals
    public function product_locals(): HasMany
    {
        return $this->hasMany(Product_Local::class, 'product_id', 'id');
    }
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'product_sale')
            ->withPivot('quantity_box', 'quantity_fraccion', 'price_box', 'price_fraccion', 'total')
            ->withTimestamps();
    }
}
