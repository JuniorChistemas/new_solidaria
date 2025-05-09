<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePayment extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'type_payment_id', 'id');
    }
}
