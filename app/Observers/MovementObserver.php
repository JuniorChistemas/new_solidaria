<?php

namespace App\Observers;

use App\Models\Movement;
use Illuminate\Support\Facades\Log;

class MovementObserver
{
    /**
     * Handle the Movement "created" event.
     *
     * @param  \App\Models\Movement  $movement
     * @return void
     */
    public function created(Movement $movement)
    {
        // Registra información del nuevo movimiento
        Log::info('Nuevo movimiento creado', [
            'id' => $movement->id,
            'code' => $movement->codigo,
            'supplier' => $movement->supplier->name ?? 'No proveedor',
            'type_movement' => $movement->typemovement->nombre ?? 'No tipo',
            'issue_date' => $movement->issue_date->format('Y-m-d'),
            'user' => $movement->user->name ?? 'No usuario'
        ]);

    }

    /**
     * Handle the Movement "updated" event.
     *
     * @param  \App\Models\Movement  $movement
     * @return void
     */
    public function updated(Movement $movement)
    {
        Log::info('Movimiento actualizado', [
            'id' => $movement->id,
            'changes' => $movement->getChanges()
        ]);
    }

    /**
     * Handle the Movement "deleted" event.
     *
     * @param  \App\Models\Movement  $movement
     * @return void
     */
    public function deleted(Movement $movement)
    {
        Log::info('Movimiento eliminado', [
            'id' => $movement->id,
            'code' => $movement->code
        ]);
    }

    /**
     * Handle the Movement "restored" event.
     *
     * @param  \App\Models\Movement  $movement
     * @return void
     */
    public function restored(Movement $movement)
    {
        Log::info('Movimiento restaurado', [
            'id' => $movement->id
        ]);
    }

    /**
     * Handle the Movement "force deleted" event.
     *
     * @param  \App\Models\Movement  $movement
     * @return void
     */
    public function forceDeleted(Movement $movement)
    {
        Log::info('Movimiento eliminado permanentemente', [
            'id' => $movement->id
        ]);
    }
}