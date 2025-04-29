<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Zone::class);
        return Inertia::render('panel/zone/indexZone');
    }

    public function listarZones(Request $request)
    {
        // authorization so you can access the method

        Gate::authorize('viewAny', Zone::class);

        try {
            $name = $request->get('name');
            // $zones = Zone::when($name, function ($query, $name) {
            //     return $query->whereLike('name', "%$name%");
            // })->orderBy('id','asc')->paginate(12);
            $zones = app(Pipeline::class)
                ->send(Zone::query())
                ->through([
                    new FilterByName($name)
                ])
                ->thenReturn()->orderBY('id', 'asc')->paginate(10);
            return response()->json([
                'zones' => ZoneResource::collection($zones),
                'pagination' => [
                    'total' => $zones->total(),
                    'current_page' => $zones->currentPage(),
                    'per_page' => $zones->perPage(),
                    'last_page' => $zones->lastPage(),
                    'from' => $zones->firstItem(),
                    'to' => $zones->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar las zonas',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/zone/components/formZone');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZoneRequest $request)
    {
        Gate::authorize('create', Zone::class);
        $validated = $request->validated();
        $validated = $request->safe()->except(['status']);
        $zone = Zone::create(Arr::except($validated, ['status']));
        // // $validated['status'] = $validated['status'] === 'activo' ? true : false;
        return redirect()->route('panel.zones.index')->with('message', 'Zona creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        Gate::authorize('view', $zone);
        return response()->json([
            'status' => true,
            'message' => 'Zona encontrada',
            'zone' => new ZoneResource($zone),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateZoneRequest $request, Zone $zone)
    {
        Gate::authorize('update', $zone);
        $validated = $request->validated();
        $validated['status'] = ($validated['status'] ?? 'inactivo') === 'activo';
        $zone->update($validated);
        return response()->json([
            'status' => true,
            'message' => 'Zona actualizada correctamente',
            'zone' => new ZoneResource($zone->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        Gate::authorize('delete', $zone);
        $zone->delete();
        return response()->json([
            'status' => true,
            'message' => 'Zona eliminada correctamente',
        ]);
    }
}
