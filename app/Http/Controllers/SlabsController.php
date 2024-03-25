<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlabsRequest;
use App\Models\Slabs;

class SlabsController extends Controller
{
    public function index()
    {
        return Slabs::all();
    }

    public function store(SlabsRequest $request)
    {
        return Slabs::create($request->validated());
    }

    public function show(Slabs $slabs)
    {
        return $slabs;
    }

    public function update(SlabsRequest $request, Slabs $slabs)
    {
        $slabs->update($request->validated());

        return $slabs;
    }

    public function destroy(Slabs $slabs)
    {
        $slabs->delete();

        return response()->json();
    }
}
