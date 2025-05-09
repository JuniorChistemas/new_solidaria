<?php

namespace App\Pipelines\Sales;

use App\Models\Sale;
use Closure;
use Illuminate\Support\Facades\Log;

class CreateSale
{
  public function __invoke($saleData, Closure $next)
  {
    $sale = Sale::create([
      'user_id' => $saleData['user_id'],
      'customer_id' => $saleData['customer_id'],
      'local_id' => $saleData['local_id'],
      'doctor_id' => $saleData['doctor_id'],
      'type_voucher_id' => $saleData['type_voucher_id'],
      'type_payment_id' => $saleData['type_payment_id'],
      'code' => $saleData['code'],
      'code_card' => $saleData['code_card'],
      'op_gravada' => $saleData['op_gravada'],
      'op_exonerada' => $saleData['op_exonerada'],
      'op_inafecta' => $saleData['op_inafecta'],
      'igv' => $saleData['igv'],
      'total' => $saleData['total'],
      'status_sale' => $saleData['status_sale'],
      'state_sunat' => $saleData['state_sunat'],
    ]);
    $saleData['sale_model'] = $sale;
    Log::info('Registrando venta');
    return $next($saleData);
  }
}
