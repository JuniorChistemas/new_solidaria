<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Http\Requests\StoreClientTypeRequest;
use App\Http\Requests\UpdateClientTypeRequest;
use App\Http\Resources\ClientTypeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', ClientType::class);
        return Inertia::render('panel/clientType/indexClientType');
    }

    public function listarClientTypes(Request $request)
    {
        Gate::authorize('viewAny', ClientType::class);
        try {
            $name = $request->get('name');
            $clientTypes = ClientType::when($name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })->orderBy('id', 'asc')->paginate(15);

            return response()->json([
                'clientTypes' => ClientTypeResource::collection($clientTypes),
                'pagination' => [
                    'total' => $clientTypes->total(),
                    'current_page' => $clientTypes->currentPage(),
                    'per_page' => $clientTypes->perPage(),
                    'last_page' => $clientTypes->lastPage(),
                    'from' => $clientTypes->firstItem(),
                    'to' => $clientTypes->lastItem()
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar los servicios',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/clientType/components/formClientType');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientTypeRequest $request)
    {
        Gate::authorize('create', ClientType::class);
        $validated = $request->validated();
        $validated = $request->safe()->except(['state']);
        $clientType = ClientType::create(Arr::except($validated, ['state']));
        return redirect()->route('panel.clientTypes.index')->with('message', 'Tipo de cliente creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientType $clientType)
    {
        Gate::authorize('view', $clientType);
        return response()->json([
            'state' => true,
            'message' => 'Tipo de cliente encontrado',
            'clientType' => new ClientTypeResource($clientType),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientTypeRequest $request, ClientType $clientType)
    {
        Gate::authorize('update', $clientType);
        $validated = $request->validated();
        $validated['state'] = ($validated['state'] ?? 'inactivo') === 'activo';
        $clientType->update($validated);
        return response()->json([
            'state' => true,
            'message' => 'Tipo de cliente actualizado de manera correcta',
            'clientType' => new ClientTypeResource($clientType->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientType $clientType)
    {
        Gate::authorize('delete', $clientType);
        $clientType->delete();
        return response()->json([
            'state' => true,
            'message' => 'Tipo de cliente eliminado de manera correcta',
        ]);
    }
}
