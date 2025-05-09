<?php

namespace App\Pipelines\Sales;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CalculateTotals
{
  public function __invoke($saleData, Closure $next)
  {
    $total = collect($saleData['products'])->sum(function ($product) {
      return $product['price_box'] * $product['quantity_box'] + $product['price_fraction'] * $product['quantity_fraction'];
    });
    if ($saleData['total'] !== $total) {
      Log::warning('El total no coincide con el calculado', [
        'total' => $total,
        'sale_data' => $saleData['total'],
      ]);
      throw ValidationException::withMessages([
        'ERROR' => 'los totales no coinciden',
      ]);
    }

    Log::info('total es correcto', [
      'products' => $saleData['products'],
    ]);

    return $next($saleData);
  }
}
