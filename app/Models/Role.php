<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Role extends Model
{
    use HasFactory, HasRoles;
    // nombre de la tabla que se le asigna al modelo
    protected $table = 'roles';
    // atributos al que va a tener acceso
    protected $fillable = [
        'name',
        //'permisos',
        'guard_name',
    ];
    // atributos que no tendra acceso
    protected $hidden = [
    ];
    // relaciones
    public function permisos(){
        return $this->belongsToMany(Permission::class,'role_has_permissions','role_id','permission_id');
    }
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'model_has_roles',
            'role_id',   // Llave foránea de la tabla model_has_roles referenciando al role
            'model_id'   // Llave foránea de la tabla model_has_roles referenciando al user
        )->wherePivot('model_type', User::class);
    }
}