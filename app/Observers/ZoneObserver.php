<?php

namespace App\Observers;

use Illuminate\Support\Carbon;

use App\Models\Zone;
use App\Models\Product;

class ZoneObserver
{
    /**
     * Handle the Zone "created" event.
     */
    public function created(Zone $zone): void
    {
        $allProductIds = Product::pluck('id');

        $timestamp = now(); // o Carbon::now()

        // Preparamos los datos con timestamps
        $syncData = $allProductIds->mapWithKeys(function ($id) use ($timestamp) {
            return [$id => ['created_at' => $timestamp, 'updated_at' => $timestamp]];
        })->toArray();

        // Asociamos productos con timestamps
        $zone->products()->attach($syncData);
    }

    /**
     * Handle the Zone "updated" event.
     */
    public function updated(Zone $zone): void
    {
        //
    }

    /**
     * Handle the Zone "deleted" event.
     */
    public function deleted(Zone $zone): void
    {
        //
    }

    /**
     * Handle the Zone "restored" event.
     */
    public function restored(Zone $zone): void
    {
        //
    }

    /**
     * Handle the Zone "force deleted" event.
     */
    public function forceDeleted(Zone $zone): void
    {
        //
    }
}
