<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('panel/user/indexUser');
    }

    public function listarUsers(Request $request)
    {
        try {
            $name = $request->get('name');
            $users = app(Pipeline::class)
                ->send(User::query())
                ->through([
                    new FilterByName($name),
                ])
                ->thenReturn()->orderBy('id', 'asc')->paginate(12);
            return response()->json([
                'users' => UserResource::collection($users),
                'pagination' => [
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ],
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos del usuario',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return Inertia::render('panel/local/indexLocal');
        return Inertia::render('panel/user/components/formUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->safe()->only([
            'name',
            'email',
            'username',
            'local_id',
            'status',
            'password',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($request->role_name);
        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'redirect_url' => route('panel.users.index'),
            'user' => new UserResource($user),
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => true,
            'message' => 'Usuario encontrado',
            'user' => new UserResource($user),
        ])->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->safe()->only([
            'name',
            'email',
            'username',
            'local_id',
            'status',
            'password',
        ]);
        $originalFields = ['local_id'];
        foreach ($originalFields as $field) {
            if (($data[$field] ?? null) === null) {
                $data[$field] = $user->{$field};
            }
        }
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        if ($request->role_name) {
            $user->syncRoles($request->role_name);
        }
        return response()->json([
            'status' => true,
            'message' => 'Usuario actualizado correctamente',
            'user' => new UserResource($user),
        ])->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'Usuario eliminado correctamente',
        ])->setStatusCode(200);
    }
}
