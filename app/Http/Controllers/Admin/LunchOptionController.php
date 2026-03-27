<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLunchOptionRequest;
use App\Http\Requests\Admin\UpdateLunchOptionRequest;
use App\Models\LunchOption;

class LunchOptionController extends Controller
{
    public function index()
    {
        $lunchOptions = LunchOption::query()->forAdminEvent()->orderBy('sort_order')->paginate(20);

        return view('admin.lunch-options.index', compact('lunchOptions'));
    }

    public function create()
    {
        return view('admin.lunch-options.create');
    }

    public function store(StoreLunchOptionRequest $request)
    {
        LunchOption::query()->create([
            ...$request->validated(),
            'event_id' => session('admin_event_id'),
        ]);

        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option created.');
    }

    public function show(LunchOption $lunch_option)
    {
        return view('admin.lunch-options.show', ['lunchOption' => $lunch_option]);
    }

    public function edit(LunchOption $lunch_option)
    {
        return view('admin.lunch-options.edit', ['lunchOption' => $lunch_option]);
    }

    public function update(UpdateLunchOptionRequest $request, LunchOption $lunch_option)
    {
        $lunch_option->update($request->validated());

        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option updated.');
    }

    public function destroy(LunchOption $lunch_option)
    {
        $lunch_option->delete();

        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option deleted.');
    }
}
