<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        return Inertia::render('panel/inventory/partials/indexInventory');
    }

    /**
     * List products with pagination and search.
     */
    public function listInventory(Request $request)
    {
        // Gate::authorize('viewAny', Product::class);

        try {
            $name = $request->get('name');
            $perPage = $request->get('per_page', 10);
            $localId = $request->get('localId');
            $laboratorioId = $request->get('laboratorioId');
            $categoriaId = $request->get('categoriaId');

            $products = Product::with(['laboratory', 'category', 'product_locals'])
                ->when($name, function ($query, $name) {
                    return $query->where('name', 'like', "%$name%");
                })
                ->when($laboratorioId, function ($query, $laboratorioId) {
                    return $query->where('laboratory_id', $laboratorioId);
                })
                ->when($categoriaId, function ($query, $categoriaId) {
                    return $query->where('category_id', $categoriaId);
                })
                ->when($localId, function ($query, $localId) {
                    return $query->whereHas('product_locals', function ($q) use ($localId) {
                        $q->where('local_id', $localId);
                    });
                })
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            $formattedProducts = $products->map(function ($product) {
                $productLocal = $product->product_locals->first();
                return [
                    'id' => $product->id,
                    'nombre' => $product->name,
                    'composicion' => $product->composition,
                    'presentacion' => $product->presentation,
                    'laboratorio' => $product->laboratory ? $product->laboratory->name : null,
                    'categoria' => $product->category ? $product->category->name : null,
                    'cajas' => $productLocal ? $productLocal->StockBox : 0,
                    'fracciones' => $productLocal ? $productLocal->StockFraction : 0,
                ];
            });

            return response()->json([
                'data' => $formattedProducts,
                'links' => [
                    'first' => $products->url(1),
                    'last' => $products->url($products->lastPage()),
                    'prev' => $products->previousPageUrl(),
                    'next' => $products->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'from' => $products->firstItem(),
                    'last_page' => $products->lastPage(),
                    'links' => $products->links()->elements,
                    'path' => $products->path(),
                    'per_page' => $products->perPage(),
                    'to' => $products->lastItem(),
                    'total' => $products->total(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al listar el inventario',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        // Gate::authorize('view', $product);

        $product->load(['laboratory', 'category', 'product_locals']);

        $formattedProduct = [
            'id' => $product->id,
            'nombre' => $product->name,
            'composicion' => $product->composition,
            'presentacion' => $product->presentation,
            'laboratorio' => $product->laboratory ? $product->laboratory->name : null,
            'categoria' => $product->category ? $product->category->name : null,
            'cajas' => $product->product_locals->first() ? $product->product_locals->first()->StockBox : 0,
            'fracciones' => $product->product_locals->first() ? $product->product_locals->first()->StockFraction : 0,
        ];

        return response()->json([
            'state' => true,
            'message' => 'Producto encontrado',
            'product' => $formattedProduct,
        ], 200);
    }
}