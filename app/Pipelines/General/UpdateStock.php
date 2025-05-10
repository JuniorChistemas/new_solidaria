<?php

namespace App\Pipelines\General;

use App\Models\Product_Local;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateStock
{
  public function __invoke($saleData, Closure $next)
  {

    $products = $saleData['products'];
    $local = Auth::user()->local_id ?? 1;

    $productIds = collect($products)->pluck('product_local_id')->all();
    $stockData = Product_Local::where('local_id', $local)
      ->whereIn('product_id', $productIds)
      ->get()
      ->keyBy('product_id');

    foreach ($products as $product) {
      $stock = $stockData->get($product['product_local_id']);
      if ($stock) {
        $requiredBox = $product['quantity_box'];
        $requiredFraction = $product['quantity_fraction'];
        $stock->StockBox -= $requiredBox;
        $stock->StockFraction -= $requiredFraction;
        $stock->save();
      }
      Log::info('actualizando stock de productos', [
        'product_id' => $product['product_local_id'],
        'local_id' => $local,
        'StockBox' => $stock->StockBox ?? 0,
        'StockFraction' => $stock->StockFraction ?? 0,
      ]);
    }
    return $next($saleData);
  }
}
