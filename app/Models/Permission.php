<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
     // nombre de la tabla que se le asigna al modelo
    protected $table = 'permissions';
     // atributos al que va a tener acceso
    protected $fillable = [
        'name',
        'guard_name ',
        'created_at',
        'updated_at',
    ];
     // atributos que no tendra acceso
    protected $hidden = [
        
    ];
     // relaciones
    public function roles(){
        return $this->belongsToMany(Role::class,'role_has_permissions','permission_id','role_id');
    }
}
