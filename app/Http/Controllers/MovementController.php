<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;
use App\Http\Resources\MovementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Movement::class);
        return Inertia::render('panel/movement/indexMovement');
    }

    /**
     * List movements with optional filtering
     */
    public function listMovements(Request $request)
    {
        Gate::authorize('viewAny', Movement::class);
        try {

            $codigo = $request->get('codigo');
            $movements = Movement::with(['supplier', 'user' , 'typemovement'])  // Cargar las relaciones
                ->when($codigo, function ($query, $codigo) {
                    return $query->where('codigo', 'like', "%$codigo%");
                })
                ->orderBy('id', 'asc')
                ->paginate(15);

            return response()->json([
                'movements' => MovementResource::collection($movements),
                'pagination' => [
                    'total' => $movements->total(),
                    'current_page' => $movements->currentPage(),
                    'per_page' => $movements->perPage(),
                    'last_page' => $movements->lastPage(),
                    'from' => $movements->firstItem(),
                    'to' => $movements->lastItem()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar los movimientos',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Movement::class);
        return Inertia::render('panel/movement/components/formMovement');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovementRequest $request)
    {
        Gate::authorize('create', Movement::class);
        $validated = $request->validated();
        $movement = Movement::create($validated);
        
        return redirect()->route('panel.movements.index')->with('message', 'Movimiento creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movement $movement)
    {
        Gate::authorize('view', $movement);
        return response()->json([
            'state' => true,
            'message' => 'Movimiento encontrado',
            'movement' => new MovementResource($movement),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movement $movement)
    {
        Gate::authorize('update', $movement);
        return Inertia::render('panel/movement/components/formMovement', [
            'movement' => new MovementResource($movement)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        Gate::authorize('update', $movement);
        $validated = $request->validated();
        $movement->update($validated);
        
        return response()->json([
            'state' => true,
            'message' => 'Movimiento actualizado de manera correcta',
            'movement' => new MovementResource($movement->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movement $movement)
    {
        Gate::authorize('delete', $movement);
        $movement->delete();
        
        return response()->json([
            'state' => true,
            'message' => 'Movimiento eliminado de manera correcta',
        ]);
    }
}