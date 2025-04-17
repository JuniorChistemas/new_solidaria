<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMovement extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'type_movements';

    // Campos que se pueden asignar masivamente
    protected $fillable = ['nombre'];

    // Relación con movimientos
    public function movements()
    {
        return $this->hasMany(Movement::class, 'idTipoMovimiento');
    }
    public function guides():HasMany{
        return $this->hasMany(Guide::class, 'type_movement_id', 'id');
    }
}
