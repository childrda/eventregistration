<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTshirtSizeRequest;
use App\Http\Requests\Admin\UpdateTshirtSizeRequest;
use App\Models\TshirtSize;

class TshirtSizeController extends Controller
{
    public function index()
    {
        $tshirtSizes = TshirtSize::query()->forAdminEvent()->orderBy('sort_order')->paginate(20);

        return view('admin.tshirt-sizes.index', compact('tshirtSizes'));
    }

    public function create()
    {
        $nextSortOrder = (int) TshirtSize::query()->forAdminEvent()->max('sort_order') + 1;

        return view('admin.tshirt-sizes.create', compact('nextSortOrder'));
    }

    public function store(StoreTshirtSizeRequest $request)
    {
        TshirtSize::query()->create([
            ...$request->validated(),
            'event_id' => session('admin_event_id'),
        ]);

        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size created.');
    }

    public function show(TshirtSize $tshirt_size)
    {
        return view('admin.tshirt-sizes.show', ['tshirtSize' => $tshirt_size]);
    }

    public function edit(TshirtSize $tshirt_size)
    {
        return view('admin.tshirt-sizes.edit', ['tshirtSize' => $tshirt_size]);
    }

    public function update(UpdateTshirtSizeRequest $request, TshirtSize $tshirt_size)
    {
        $tshirt_size->update($request->validated());

        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size updated.');
    }

    public function destroy(TshirtSize $tshirt_size)
    {
        $tshirt_size->delete();

        return redirect()->route('admin.tshirt-sizes.index')->with('success', 'T-shirt size deleted.');
    }
}
