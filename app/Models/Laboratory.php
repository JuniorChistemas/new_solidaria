<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laboratory extends Model
{
    /** @use HasFactory<\Database\Factories\LaboratoryFactory> */
    use HasFactory;

    // protected $table = 'laboratories'; // Nombre de la tabla

    protected $fillable = [
        'name',
        'state',
    ];

    protected $casts = [
        'state' => 'boolean',
    ];
    
    public function Products():HasMany{
        return $this->hasMany(Product::class); 
    }
}
