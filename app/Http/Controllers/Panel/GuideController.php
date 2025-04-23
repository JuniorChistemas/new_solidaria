<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides = Guide::with('originLocals', 'destinationLocals', 'typeMovements')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return response()->json([
            'guides' => GuideResource::collection($guides),
        ]);
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
            'message' => 'Guide deleted successfully',
        ]);
    }
}
