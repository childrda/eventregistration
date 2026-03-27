<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreTshirtSizeRequest;
use App\Http\Requests\Admin\UpdateTshirtSizeRequest;
use App\Http\Controllers\Controller;
use App\Models\TshirtSize;

class TshirtSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tshirtSizes = TshirtSize::query()->orderBy('sort_order')->paginate(20);
        return view('admin.tshirt-sizes.index', compact('tshirtSizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextSortOrder = (int) TshirtSize::query()->max('sort_order') + 1;
        return view('admin.tshirt-sizes.create', compact('nextSortOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTshirtSizeRequest $request)
    {
        TshirtSize::query()->create($request->validated());
        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TshirtSize $tshirt_size)
    {
        return view('admin.tshirt-sizes.show', ['tshirtSize' => $tshirt_size]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TshirtSize $tshirt_size)
    {
        return view('admin.tshirt-sizes.edit', ['tshirtSize' => $tshirt_size]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTshirtSizeRequest $request, TshirtSize $tshirt_size)
    {
        $tshirt_size->update($request->validated());
        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TshirtSize $tshirt_size)
    {
        $tshirt_size->delete();
        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size deleted.');
    }
}
