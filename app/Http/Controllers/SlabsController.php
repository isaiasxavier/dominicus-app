<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlabsRequest;
use App\Models\Slab;

class SlabsController extends Controller
{
    public function index()
    {
        return Slab::all();
    }

    public function store(SlabsRequest $request)
    {
        return Slab::create($request->validated());
    }

    public function show(Slab $slabs)
    {
        return $slabs;
    }

    public function update(SlabsRequest $request, Slab $slabs)
    {
        $slabs->update($request->validated());

        return $slabs;
    }

    public function destroy(Slab $slabs)
    {
        $slabs->delete();

        return response()->json();
    }
}
