<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];
    protected $casts = [
        'code' => 'integer',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'type_voucher_id', 'id');
    }
}
