<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'fechaEmision',
        'fechaEjecucion',
        'fechaCredito',
        'idProveedor',
        'idLocal',
        'idUser',
        'idTipoMovimiento',
        'estado',
        'estadoIgv',
        'estadoIngreso',
        'tipoPago',
    ];

    protected $casts = [
        'fechaEmision' => 'date',
        'fechaEjecucion' => 'date',
        'fechaCredito' => 'date',
        'tipoPago' => 'string',
    ];

    /**
     * Relación con el proveedor
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'idProveedor');
    }

    /**
     * Relación con el local
     */
    public function local()
    {
        return $this->belongsTo(Local::class, 'idLocal');
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}