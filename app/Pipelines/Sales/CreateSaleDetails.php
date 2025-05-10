<?php

namespace App\Pipelines\Sales;

use Closure;
use Illuminate\Support\Facades\Log;

class CreateSaleDetails
{
  public function __invoke($saleData, Closure $next)
  {

    $sale = $saleData['sale_model'];
    $products = $saleData['products'];
    $pivotData = [];

    foreach ($products as $product) {
      $pivotData[$product['product_local_id']] = [
        'quantity_box' => $product['quantity_box'] ?? 0,
        'quantity_fraction' => $product['quantity_fraction'] ?? 0,
        'price_box' => $product['price_box'] ?? 0,
        'price_fraction' => $product['price_fraction'] ?? 0,
      ];
    }
    $sale->products()->attach($pivotData);
    Log::info('crear detalle para la tabla sale_products', [
      'sale_id' => $sale->id,
      'cantidad de productos' => count($pivotData),
    ]);
    return $next($saleData);
  }
}
