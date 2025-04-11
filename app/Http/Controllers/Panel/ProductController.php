<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Laboratory;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        return Inertia::render('panel/product/indexProduct');
    }

    public function listarProducts(Request $request)
    {
        // authorization so you can access the method

        Gate::authorize('viewAny', Product::class);

        try {
            $name = $request->get('name');
            $products = Product::when($name, function ($query, $name) {
                return $query->whereLike('name', "%$name%");
            })->orderBy('id','asc')->paginate(10);
            return response()->json([
                'products'=> ProductResource::collection($products),
                'pagination' => [
                    'total' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos del producto',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
    $laboratory = Laboratory::select('id', 'name')
        ->orderBy('id')
        ->get();
    $category = Category::select('id', 'name')
        ->orderBy('id')
        ->get();

    return Inertia::render('panel/product/components/formProduct', [
        'categories' => $category, 
        'laboratories' => $laboratory,
    ]);
    }
    public function store(StoreProductRequest $request)
    {
        Gate::authorize('create', Product::class);
        $validated = $request->validated();
        $product = Product::create($validated);
        return redirect()->route('panel.products.index')->with('message', 'Producto creado correctamente');   
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        Gate::authorize('view', $product);
        return response()->json([
            'state' => true,
            'status' => true,
            'message' => 'Producto encontrado',
            'product' => new ProductResource($product),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);
        $validated = $request->validated();
        $validated['state'] = ($validated['state'] ?? false) === true;
        $validated['state_fraction'] = ($validated['state_fraction'] ?? false) === true;
        $validated['state_igv'] = ($validated['state_igv'] ?? false) === true;
        $validated['status'] = ($validated['status'] ?? false) === true;
        $product->update($validated);
        return response()->json([
            'state' => true,
            'state_fraction' => true,
            'state_igv' => true,
            'status' => true,
            'message' => 'Producto actualizado de manera correcta',
            'product' => new ProductResource($product->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);
        $product->delete();
        return response()->json([
            'state' => true,
            'message' => 'Producto eliminado de manera correcta',
        ]);
    }
}
