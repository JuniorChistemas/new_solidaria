<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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

    public function listInventory(Request $request)
    {
        Gate::authorize('viewAny', Product::class);

        try {
            $nombre = $request->query('nombre');
            $perPage = $request->query('per_page', 10);
            $localId = $request->query('localId');
            $laboratorioId = $request->query('laboratorioId');
            $categoriaId = $request->query('categoriaId');
            $estadoStock = $request->query('estadoStock', '3');


            $query = Product::with(['laboratory', 'category', 'product_locals' => function ($q) use ($localId, $estadoStock) {
                if ($localId) {
                    $q->where('local_id', $localId);
                }
                if ($estadoStock == '0') {
                    $q->where('StockBox', 0)->where('StockFraction', 0);
                } elseif ($estadoStock == '1') {
                    $q->where(function ($subquery) {
                        $subquery->where('StockBox', '>', 0)
                            ->orWhere('StockFraction', '>', 0);
                    });
                }
            }]);

            if ($nombre) {
                $query->where('name', 'like', "%$nombre%");
            }

            if ($laboratorioId) {
                $query->where('laboratory_id', $laboratorioId);
            }

            if ($categoriaId) {
                $query->where('category_id', $categoriaId);
            }

            if ($localId) {
                $query->whereHas('product_locals', function ($q) use ($localId) {
                    $q->where('local_id', $localId);
                });
            }

            if ($estadoStock != '3') {
                $query->whereHas('product_locals', function ($q) use ($estadoStock, $localId) {
                    if ($localId) {
                        $q->where('local_id', $localId);
                    }
                    if ($estadoStock == '1') {
                        $q->where(function ($subquery) {
                            $subquery->where('StockBox', '>', 0)
                                ->orWhere('StockFraction', '>', 0);
                        });
                    } elseif ($estadoStock == '0') {
                        $q->where('StockBox', 0)
                            ->where('StockFraction', 0);
                    }
                });
            }

            $products = $query->orderBy('id', 'asc')->paginate($perPage);

            $formattedProducts = $products->map(function ($product) use ($localId, $estadoStock) {

                $productLocal = null;
                if ($localId) {
                    $productLocal = $product->product_locals
                        ->where('local_id', $localId)
                        ->when($estadoStock == '0', function ($collection) {
                            return $collection->where('StockBox', 0)->where('StockFraction', 0);
                        })
                        ->first();
                } else {

                    $productLocal = $product->product_locals
                        ->when($estadoStock == '0', function ($collection) {
                            return $collection->where('StockBox', 0)->where('StockFraction', 0);
                        })
                        ->first();
                }

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
            Log::error('Error listing inventory:', ['error' => $th->getMessage()]);
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
        Gate::authorize('view', $product);

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
