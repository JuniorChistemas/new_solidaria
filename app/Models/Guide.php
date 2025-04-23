<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function originLocals():BelongsTo{
        return $this->belongsTo(Local::class, 'origin_local_id', 'id');
    }

    public function destinationLocals():BelongsTo{
        return $this->belongsTo(Local::class, 'destination_local_id', 'id');
    }

    public function typeMovements(): BelongsTo{
        return $this->belongsTo(TypeMovement::class, 'type_movement_id', 'id');
    }


}
