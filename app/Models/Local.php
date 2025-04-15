<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'series',
        'series_note',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    
    // Relación con movements
    public function movements()
    {
        return $this->hasMany(Movement::class, 'idLocal');
    }
}

