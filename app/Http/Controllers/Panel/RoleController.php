<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class);
        return Inertia::render('panel/role/indexRole');
    }

    public function listarRoles(Request $request)
    {
        // authorization so you can access the method

        Gate::authorize('viewAny', Role::class);

        try {
            $name = $request->get('name');
            $roles = app(Pipeline::class)
                ->send(Role::query())
                ->through([
                    new FilterByName($name),
                ])
                ->thenReturn()->orderBy('id','asc')->paginate(12);
            return response()->json([
                'roles'=> RoleResource::collection($roles),
                'pagination' => [
                    'total' => $roles->total(),
                    'current_page' => $roles->currentPage(),
                    'per_page' => $roles->perPage(),
                    'last_page' => $roles->lastPage(),
                    'from' => $roles->firstItem(),
                    'to' => $roles->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar los roles',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('panel/role/components/formRole', [
            'permisos' => $permissions,  // Pasando los permisos a la vista
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('create', Role::class);
        $validated = $request->validated();
        // Verifica si guard_name está presente, si no, agrega un valor predeterminado
        if (!isset($validated['guard_name'])) {
            $validated['guard_name'] = 'web'; // Asigna un valor predeterminado si no se pasa
        }
            // Crear el rol
        $role = Role::create($validated);

        // Sincronizar permisos seleccionados con el rol
        $role->permisos()->sync($request->permisos);  // Aquí estamos sincronizando los permisos seleccionados

        return redirect()->route('panel.roles.index')->with('message', 'Rol creado correctamente');   
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('view', $role);
        return response()->json([
            'status' => true,
            'message' => 'Rol encontrado',
            'role' => new RoleResource($role),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('update', $role);
        $validated = $request->validated();
        $role->update($validated);
        //$role->permisos()->sync($request->permisos);
        return response()->json([
            'status' => true,
            'message' => 'Rol actualizado correctamente',
            'role' => new RoleResource($role->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);
        $role->delete();
        return response()->json([
            'status' => true,
            'message' => 'Rol eliminado correctamente',
        ]);
    }

}