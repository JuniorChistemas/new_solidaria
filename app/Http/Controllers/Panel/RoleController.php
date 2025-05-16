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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

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
        return Inertia::render('panel/role/components/formRole');
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

    public function edit(Role $role)
    {
        // Obtener todos los permisos
        $permissions = Permission::all();

        // Obtener los permisos del rol
        $rolePermissions = $role->permisos;

        // Pasar los permisos al formulario de edición
        return Inertia::render('panel/role/components/formEditRole', [
            'roleData' => $role,
            'permisos' => $permissions,
            'selectedPermissions' => $rolePermissions->pluck('id')->toArray(),  // Pasar los permisos seleccionados
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('update', $role);

        //Log::info('Datos recibidos para actualizar rol:', $request->all());

        // Validar y actualizar el rol
        $validated = $request->validated();
        $role->update($validated);

        // Sincronizar los permisos seleccionados
        $role->permisos()->sync($request->permisos);
     
        // Recargar la relación permisos para que se incluyan en la respuesta JSON
        $role->load('permisos');
        return response()->json([
            'status' => true,
            'message' => 'Rol actualizado correctamente',
            'role' => new RoleResource($role),
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