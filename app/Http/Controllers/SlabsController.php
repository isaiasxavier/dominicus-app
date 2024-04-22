<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlabsRequest;
use App\Models\Slab;

class SlabsController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Slab::all();
    }

    public function store(SlabsRequest $request)
    {
        return Slab::create($request->validated());
    }

    public function show(Slab $slabs): Slab
    {
        return $slabs;
    }

    public function update(SlabsRequest $request, Slab $slabs): Slab
    {
        $slabs->update($request->validated());

        return $slabs;
    }

    public function destroy(Slab $slabs): \Illuminate\Http\JsonResponse
    {
        $slabs->delete();

        return response()->json();
    }
}
