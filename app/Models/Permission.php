<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'permissions';

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'guard_name',
    ];

    // Atributos que se ocultarán al serializar
    protected $hidden = [
        // No hay campos ocultos por ahora
    ];

    // Relaciones: aún no se definen, se agregarán más adelante si se requiere
}
