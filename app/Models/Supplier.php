<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'ruc',
        'phone',
        'address',
        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
    ];

    // Relación con movements
    public function movements()
    {
        return $this->hasMany(Movement::class, 'idProveedor');
    }
}
