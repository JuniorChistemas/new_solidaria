<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Permission::class);
        return Inertia::render('panel/permission/indexPermission');
    }

    public function listarPermissions(Request $request)
    {
        Gate::authorize('viewAny', Permission::class);

        try {
            $name = $request->get('name');

            $permissions = Pipeline::send($name)
                ->send(Permission::query())
                ->through([
                    new FilterByName($name)
                ])
                ->thenReturn()->orderBy('id', 'asc')->paginate(10);

            return response()->json([
                'permissions' => PermissionResource::collection($permissions),
                'pagination' => [
                    'total' => $permissions->total(),
                    'current_page' => $permissions->currentPage(),
                    'per_page' => $permissions->perPage(),
                    'last_page' => $permissions->lastPage(),
                    'from' => $permissions->firstItem(),
                    'to' => $permissions->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar los permisos',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/permission/components/formPermission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        Gate::authorize('create', Permission::class);
        $validated = $request->validated();
        if (!isset($validated['guard_name'])) {
            $validated['guard_name'] = 'web'; // Asigna un valor predeterminado si no se pasa
        }
        $permission = Permission::create($validated);

        return redirect()->route('panel.permissions.index')->with('message', 'Permiso creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        Gate::authorize('view', $permission);
        return response()->json([
            'status' => true,
            'message' => 'Permiso encontrado',
            'permission' => new PermissionResource($permission),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        Gate::authorize('update', $permission);
        $validated = $request->validated();
        $permission->update(Arr::only($validated, ['name']));

        return response()->json([
            'status' => true,
            'message' => 'Permiso actualizado correctamente',
            'permission' => new PermissionResource($permission->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        Gate::authorize('delete', $permission);
        $permission->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permiso eliminado correctamente',
        ]);
    }
}
