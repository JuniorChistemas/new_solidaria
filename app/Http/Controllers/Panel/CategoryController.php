<?php

namespace App\Http\Controllers\Panel;

use App\Exports\CategoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Pipelines\FilterByName;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Category::class);
        return Inertia::render('panel/category/indexCategory');
    }

    public function listarCategories(Request $request)
    {
        // authorization so you can access the method

        Gate::authorize('viewAny', Category::class);

        try {
            $name = $request->get('name');
            $categories = app(Pipeline::class)
                ->send(Category::query())
                ->through([
                    new FilterByName($name),
                ])
                ->thenReturn()->orderBy('id','asc')->paginate(12);
            return response()->json([
                'categories'=> CategoryResource::collection($categories),
                'pagination' => [
                    'total' => $categories->total(),
                    'current_page' => $categories->currentPage(),
                    'per_page' => $categories->perPage(),
                    'last_page' => $categories->lastPage(),
                    'from' => $categories->firstItem(),
                    'to' => $categories->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar las categorías',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('panel/category/components/formCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create', Category::class);
        $validated = $request->validated();
        $validated = $request->safe()->except(['status']);
        $category = Category::create(Arr::except($validated, ['status']));
        // // $validated['status'] = $validated['status'] === 'activo' ? true : false;
        return redirect()->route('panel.categories.index')->with('message', 'Categoría creada correctamente');   
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        Gate::authorize('view', $category);
        return response()->json([
            'status' => true,
            'message' => 'Categoría encontrada',
            'category' => new CategoryResource($category),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::authorize('update', $category);
        $validated = $request->validated();
        $validated['status'] = ($validated['status'] ?? 'inactivo') === 'activo';
        $category->update($validated);
        return response()->json([
            'status' => true,
            'message' => 'Categoría actualizada correctamente',
            'category' => new CategoryResource($category->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Categoría eliminada correctamente',
        ]);
    }

    // EXPORTAR A EXCEL
    public function exportExcel()
    {
        return Excel::download(new CategoryExport, 'categorías.xlsx');
    }

    // IMPORTAR EXCEL
    public function importExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new CategoryImport, $request->file('archivo'));
        
        return response()->json([
            'message' => 'Importación de categorias realizado correctamente',
        ]);
    }
}
