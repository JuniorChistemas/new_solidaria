<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'issue_date',
        'credit_date',
        'supplier_id',
        'user_id',
        'type_movement_id',
        'status',
        'igv_status',
        'payment_type',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'credit_date' => 'date',
        'payment_type' => 'string',
    ];

    /**
     * Relación con el proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con TypeMovement
    public function typemovement()
    {
        return $this->belongsTo(TypeMovement::class, 'type_movement_id');
    }
}