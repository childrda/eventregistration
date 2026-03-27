<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreContentSectionRequest;
use App\Http\Requests\Admin\UpdateContentSectionRequest;
use App\Http\Controllers\Controller;
use App\Models\ContentSection;

class ContentSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contentSections = ContentSection::query()->orderBy('sort_order')->paginate(20);
        return view('admin.content-sections.index', compact('contentSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentSectionRequest $request)
    {
        ContentSection::query()->create($request->validated());
        return redirect()->route('admin.content-sections.index')->with('success', 'Section created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentSection $content_section)
    {
        return view('admin.content-sections.show', ['contentSection' => $content_section]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentSection $content_section)
    {
        return view('admin.content-sections.edit', ['contentSection' => $content_section]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentSectionRequest $request, ContentSection $content_section)
    {
        $content_section->update($request->validated());
        return redirect()->route('admin.content-sections.index')->with('success', 'Section updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentSection $content_section)
    {
        $content_section->delete();
        return redirect()->route('admin.content-sections.index')->with('success', 'Section deleted.');
    }
}
