<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocalRequest;
use App\Http\Requests\UpdateLocalRequest;
use App\Http\Resources\LocalResource;
use App\Models\Local;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;

class LocalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Local::class);
        return Inertia::render('panel/local/indexLocal');
    }

    /**
     * List locals with pagination and optional filtering by name.
     */
    public function listarLocals(Request $request)
    {
        // Autorización para ver los registros
        Gate::authorize('viewAny', Local::class);

        try {
            $name = $request->get('name');
            $locals = app(Pipeline::class)
                ->send(Local::query())
                ->through([
                    new FilterByName($name)
                ])
                ->thenReturn()->orderBy('id', 'asc')->paginate(12);
            return response()->json([
                'locals' => LocalResource::collection($locals),
                'pagination' => [
                    'total'        => $locals->total(),
                    'current_page' => $locals->currentPage(),
                    'per_page'     => $locals->perPage(),
                    'last_page'    => $locals->lastPage(),
                    'from'         => $locals->firstItem(),
                    'to'           => $locals->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error listing locals',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/local/components/formLocal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocalRequest $request)
    {
        Gate::authorize('create', Local::class);
        $validated = $request->validated();
        // Si el campo 'status' se maneja aparte, se puede omitir del arreglo
        $local = Local::create(Arr::except($validated, ['status']));
        return redirect()->route('panel.locals.index')
            ->with('message', 'Local creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Local $local)
    {
        Gate::authorize('view', $local);
        return response()->json([
            'status'  => true,
            'message' => 'Local found',
            'local'   => new LocalResource($local),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocalRequest $request, Local $local)
    {
        Gate::authorize('update', $local);
        $validated = $request->validated();
        // Convertir status a boolean en función del valor recibido (activo/inactivo)
        $validated['status'] = ($validated['status'] ?? 'inactivo') === 'activo';
        $local->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Local actualizado correctamente',
            'local'   => new LocalResource($local->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Local $local)
    {
        Gate::authorize('delete', $local);
        $local->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Local eliminado correctamente',
        ]);
    }
}
