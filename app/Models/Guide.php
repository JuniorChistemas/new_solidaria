<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_local_id',
        'destination_local_id',
        'type_movement_id',
        'code',
        'status',
        'sent_at',
    ];

    public function originLocals(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'origin_local_id', 'id');
    }

    public function destinationLocals(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'destination_local_id', 'id');
    }

    public function typeMovements(): BelongsTo
    {
        return $this->belongsTo(TypeMovement::class, 'type_movement_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product_Local::class, 'guide_products', 'guide_id', 'product_local_id')
            ->using(guide_products::class)
            ->withPivot('quantity_box', 'quantity_fraction')
            ->withTimestamps();
    }
}
