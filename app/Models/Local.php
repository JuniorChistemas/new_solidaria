<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    public function guidesOrigin(): HasMany{
        return $this->hasMany(Guide::class, 'origin_local_id', 'id');
    }

    public function guidesDestination(): HasMany{
        return $this->hasMany(Guide::class, 'destination_local_id', 'id');
    }
}

