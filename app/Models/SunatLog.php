<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SunatLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'file_name',
        'file_path_xml',
        'file_path_cdr',
        'status',
        'description',
    ];
    protected $casts = [
        'file_path_cdr' => 'string',
        'status' => 'string',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
