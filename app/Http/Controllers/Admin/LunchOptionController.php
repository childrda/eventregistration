<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreLunchOptionRequest;
use App\Http\Requests\Admin\UpdateLunchOptionRequest;
use App\Http\Controllers\Controller;
use App\Models\LunchOption;

class LunchOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lunchOptions = LunchOption::query()->orderBy('sort_order')->paginate(20);
        return view('admin.lunch-options.index', compact('lunchOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lunch-options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLunchOptionRequest $request)
    {
        LunchOption::query()->create($request->validated());
        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LunchOption $lunch_option)
    {
        return view('admin.lunch-options.show', ['lunchOption' => $lunch_option]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LunchOption $lunch_option)
    {
        return view('admin.lunch-options.edit', ['lunchOption' => $lunch_option]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLunchOptionRequest $request, LunchOption $lunch_option)
    {
        $lunch_option->update($request->validated());
        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LunchOption $lunch_option)
    {
        $lunch_option->delete();
        return redirect()->route('admin.lunch-options.index')->with('success', 'Lunch option deleted.');
    }
}
