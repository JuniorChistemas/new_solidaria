<?php

namespace App\Observers;

use App\Models\Local;
use App\Models\Product;
use App\Models\Product_Local;
use App\Models\Product_Record;
use App\Models\Product_Zone;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $numberZone = Zone::count();
        for ($i = 1; $i <= $numberZone; $i++) {
           Product_Zone::create([
            'product_id' => $product->id,
            'zone_id' => $i,
            'purchase_price' => 0,
            'percentage' => 0,
            'unit_price' => 0,
            'fraction_price' => 0,
           ]);
        }
        $numberLocals = Local::count();
        for ($i = 1; $i <= $numberLocals; $i++) {
            Product_Local::create([
                'product_id' => $product->id,
                'local_id' => $i,
                'StockFraction' => 0,
                'StockBox' => 0,
                'stock_min' => 3,
                'stock_max' => 5,
            ]);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $userLogin = Auth::user();
        Product_Record::create([
            'description' => "Producto {$product->name} fue actualizado por {$userLogin->name}",
        ]);
        Log::info("Producto {$product->name} updated");
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Product_Record::create([
            'description' => "Producto {$product->name} deleted",
        ]);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
