<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Pipelines\FilterByCode;
use App\Pipelines\FilterByName;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Pipeline;
use Inertia\Inertia;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Doctor::class);
        return Inertia::render('panel/doctor/indexDoctor');
    }

    public function listarDoctors(Request $request){
        Gate::authorize('viewAny', Doctor::class);
        try {
            $name = $request->get('name');
            $doctors = Pipeline::send($name)
                ->send(Doctor::query())
                ->through([
                    new FilterByName($name),
                ])
                ->thenReturn()->orderBy('id','asc')->paginate(12);
            return response()->json([
                'doctors'=> DoctorResource::collection($doctors),
                'pagination' => [
                    'total' => $doctors->total(),
                    'current_page' => $doctors->currentPage(),
                    'per_page' => $doctors->perPage(),
                    'last_page' => $doctors->lastPage(),
                    'from' => $doctors->firstItem(),
                    'to' => $doctors->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos del doctor',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/doctor/components/formDoctor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        Gate::authorize('create', Doctor::class);
        $validated = $request->validated();
        $doctors = Doctor::create($validated);
        return redirect()->route('panel.doctors.index')->with('message', 'Doctor creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        Gate::authorize('view', $doctor);
        return response()->json([
            'status' => true,
            'message' => 'Doctor encontrado',
            'doctor' => new DoctorResource($doctor),
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        Gate::authorize('update', $doctor);
    
        $validated = $request->validated();
    
        // Parseo simple con Carbon (automáticamente entiende '2024-04-27T15:18')
        $validated['start_date'] = Carbon::parse($validated['start_date']);
    
        $doctor->update($validated);
    
        return response()->json([
            'status' => true,
            'message' => 'Doctor actualizado correctamente',
            'doctor' => new DoctorResource($doctor),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        Gate::authorize('delete', $doctor);
        $doctor->delete();
        return response()->json([
            'status' => true,
            'message' => 'Doctor eliminado correctamente',
        ], 200);
    }
}
