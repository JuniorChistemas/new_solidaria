<?php

namespace App\Http\Controllers\Panel;

use App\Exports\LaboratoryExport;
use App\Http\Controllers\Controller;
use App\Models\Laboratory;
use App\Http\Requests\StoreLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Http\Resources\LaboratoryResource;
use App\Imports\LaboratoryImport;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Laboratory::class);
        return Inertia::render('panel/laboratory/indexLaboratory');
    }

    public function listarLaboratories(Request $request)
    {
        Gate::authorize('viewAny', Laboratory::class);

        try {
            $name = $request->get('name');
            $laboratories = Pipeline::send($name)
                ->send(Laboratory::query())
                ->through([
                    new FilterByName($name),
                ])
                ->thenReturn()->orderBy('id', 'asc')->paginate(12);

            return response()->json([
                'laboratories' => LaboratoryResource::collection($laboratories),
                'pagination' => [
                    'total' => $laboratories->total(),
                    'current_page' => $laboratories->currentPage(),
                    'per_page' => $laboratories->perPage(),
                    'last_page' => $laboratories->lastPage(),
                    'from' => $laboratories->firstItem(),
                    'to' => $laboratories->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar los laboratorios',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function create()
    {
        return Inertia::render('panel/laboratory/components/formLaboratory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaboratoryRequest $request)
    {
        Gate::authorize('create', Laboratory::class);
        $validated = $request->validated(); // ya tiene state como boolean
        $laboratory = Laboratory::create($validated);
        return redirect()->route('panel.laboratories.index')->with('message', 'Laboratorio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratory $laboratory)
    {
        Gate::authorize('view', $laboratory);
        return response()->json([
            'state' => true,
            'message' => 'Laboratorio encontrado',
            'laboratory' => new LaboratoryResource($laboratory),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaboratoryRequest $request, Laboratory $laboratory)
    {
        Gate::authorize('update', $laboratory);
        $validated = $request->validated();
        $validated['state'] = ($validated['state'] ?? false) === true;
        $laboratory->update($validated);
        return response()->json([
            'state' => true,
            'message' => 'Laboratorio actualizado de manera correcta',
            'laboratory' => new LaboratoryResource($laboratory->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratory $laboratory)
    {
        Gate::authorize('delete', $laboratory);
        $laboratory->delete();
        return response()->json([
            'state' => true,
            'message' => 'Laboratorio eliminado de manera correcta',
        ]);
    }

    public function validateName(Request $request)
    {
        $name = strtoupper($request->get('name'));
        $exists = Laboratory::whereRaw('UPPER(name) = ?', [$name])->exists();

        return response()->json(['exists' => $exists]);
    }

    // EXPORTAR A EXCEL
    public function exportExcel()
    {
        return Excel::download(new LaboratoryExport, 'laboratorios.xlsx');
    }

    // IMPORTAR EXCEL
    public function importExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new LaboratoryImport, $request->file('archivo'));

        return response()->json([
            'message' => 'Importación de laboratorios realizado correctamente',
        ]);
    }
}
