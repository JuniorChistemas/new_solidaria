<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuidePipelineRequest;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use App\Pipelines\General\UpdateStock;
use App\Pipelines\General\validateProducts;
use App\Pipelines\Guides\CreateGuide;
use App\Pipelines\Guides\CreateGuideDetails;
use Illuminate\Support\Facades\Pipeline as FacadesPipeline;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Gate::authorize('viewAny', Guide::class);
        $guides = Guide::with('originLocals', 'destinationLocals', 'typeMovements')
            ->orderBy('id', 'asc')
            ->paginate(10);
        return response()->json([
            'guides' => GuideResource::collection($guides),
            'pagination' => [
                'total' => $guides->total(),
                'current_page' => $guides->currentPage(),
                'per_page' => $guides->perPage(),
                'last_page' => $guides->lastPage(),
                'from' => $guides->firstItem(),
                'to' => $guides->lastItem(),
            ],
        ])->setStatusCode(200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuideRequest $request)
    {
        // Gate::authorize('create', Guide::class);
        $validated = $request->validated();
        $guide = Guide::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'Guide created successfully',
            'guide' => new GuideResource($guide),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guide $guide)
    {
        return response()->json([
            'status' => true,
            'guide' => new GuideResource($guide),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        $validated = $request->validated();
        $guide->update($validated);
        return response()->json([
            'message' => 'Guide updated successfully',
            'guide' => new GuideResource($guide),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        $guide->delete();
        return response()->json([
            'message' => 'Guia eliminada correctamente',
        ]);
    }

    public function pruebaApi()
    {
        return response()->json([
            'message' => 'hola desde la api',
        ]);
    }

    public function sendGuide(GuidePipelineRequest $request)
    {
        $guideData = $request->validated();
        $guide = FacadesPipeline::send($guideData)
            ->through([
                validateProducts::class,
                CreateGuide::class,
                CreateGuideDetails::class,
                UpdateStock::class,
            ])
            ->thenReturn();
        return response()->json([
            'status' => true,
            'message' => 'Guia enviada correctamente',
            'guide' => $guide,
        ])->setStatusCode(200);
    }
}
