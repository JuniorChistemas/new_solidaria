<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'local_id',
        'doctor_id',
        'type_voucher_id',
        'type_payment_id',
        'code',
        'code_card',
        'op_gravada',
        'op_exonerada',
        'op_inafecta',
        'igv',
        'total',
        'status_sale',
        'state_sunat',
    ];
    protected $casts = [
        'op_gravada' => 'double',
        'op_exonerada' => 'double',
        'op_inafecta' => 'double',
        'igv' => 'double',
        'total' => 'double',
        'status_sale' => 'boolean',
        'state_sunat' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class, 'local_id', 'id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
    public function typeVoucher(): BelongsTo
    {
        return $this->belongsTo(TypeVoucher::class, 'type_voucher_id', 'id');
    }
    public function typePayment(): BelongsTo
    {
        return $this->belongsTo(TypePayment::class, 'type_payment_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product_Local::class, 'product_sale', 'sale_id', 'product_local_id')
            ->using(ProductSale::class)
            ->withPivot('quantity_box', 'quantity_fraction', 'price_box', 'price_fraction')
            ->withTimestamps();
    }
}
