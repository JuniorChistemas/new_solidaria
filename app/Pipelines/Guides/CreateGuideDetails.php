<?php

namespace App\Pipelines\Guides;

use Closure;
use Illuminate\Support\Facades\Log;

class CreateGuideDetails
{
  public function __invoke($request, Closure $next)
  {
    $guide = $request['guide_model'];
    $products = $request['products'];

    $pivotData = [];

    foreach ($products as $product) {
      $pivotData[$product['product_local_id']] = [
        'quantity_box' => $product['quantity_box'] ?? 0,
        'quantity_fraction' => $product['quantity_fraction'] ?? 0,
      ];
    }
    $guide->products()->attach($pivotData);
    Log::info('crear detalle para la tabla guide_products', [
      'guide_id' => $guide->id,
      'cantidad de productos' => count($pivotData),
    ]);
    return $next($request);
  }
}
