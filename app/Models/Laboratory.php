<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    /** @use HasFactory<\Database\Factories\LaboratoryFactory> */
    use HasFactory;

    // protected $table = 'laboratories'; // Nombre de la tabla

    protected $fillable = [
        'name',
        'state',
    ];
}
