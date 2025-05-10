<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'firstname',
        'lastname',
        'address',
        'phone',
        'birthdate',
        'client_type_id',
    ];
    protected $casts = [
        'birthdate' => 'datetime',
    ];

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'id');
    }
}
