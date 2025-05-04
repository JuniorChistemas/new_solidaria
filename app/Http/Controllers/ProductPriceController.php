<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use App\Models\ProductPrice;
use App\Models\Product;
use App\Http\Requests\StoreProduct_priceRequest;
use App\Http\Requests\UpdateProduct_priceRequest;
use App\Http\Resources\ProductpriceResource;


class ProductPriceController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Productprice::class);
        return Inertia::render('panel/product_price/indexProductprice');
    }

    public function listarProductsprice(Request $request)
    {
        // authorization so you can access the method

        Gate::authorize('viewAny', Productprice::class);

        try {
            $id = $request->get('id');
            $productsprice = Productprice::when($id, function ($query, $id) {
                return $query->whereLike('id', "%$id%");
            })->orderBy('id','asc')->paginate(10);
            return response()->json([
                'productsprice'=> ProductpriceResource::collection($productsprice),
                'pagination' => [
                    'total' => $productsprice->total(),
                    'current_page' => $productsprice->currentPage(),
                    'per_page' => $productsprice->perPage(),
                    'last_page' => $productsprice->lastPage(),
                    'from' => $productsprice->firstItem(),
                    'to' => $productsprice->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos de los precios de producto',
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    public function show(Productprice $productprice)
    {
        Gate::authorize('view', $productprice);
        return response()->json([
            'state' => true,
            'message' => 'Producto encontrado',
            'product_price' => new ProductpriceResource($productprice),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct_priceRequest $request, Productprice $productprice)
    {
        Gate::authorize('update', $productprice);
        $validated = $request->validated();
        $validated['state'] = ($validated['state'] ?? false) === true;
        $productprice->update($validated);
        return response()->json([
            'state' => true,
            'message' => 'Producto actualizado de manera correcta',
            'product' => new ProductpriceResource($productprice->refresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productprice $productprice)
    {
        Gate::authorize('delete', $productprice);
        $productprice->delete();
        return response()->json([
            'state' => true,
            'message' => 'Producto precio eliminado de manera correcta',
        ]);
    }
}
