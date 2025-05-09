<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Canceled extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'user_id',
        'description'
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
