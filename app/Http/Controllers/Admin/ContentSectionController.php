<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContentSectionRequest;
use App\Http\Requests\Admin\UpdateContentSectionRequest;
use App\Models\ContentSection;

class ContentSectionController extends Controller
{
    public function index()
    {
        $contentSections = ContentSection::query()->forAdminEvent()->orderBy('sort_order')->paginate(20);

        return view('admin.content-sections.index', compact('contentSections'));
    }

    public function create()
    {
        return view('admin.content-sections.create');
    }

    public function store(StoreContentSectionRequest $request)
    {
        ContentSection::query()->create([
            ...$request->validated(),
            'event_id' => session('admin_event_id'),
        ]);

        return redirect()->route('admin.content-sections.index')->with('success', 'Section created.');
    }

    public function show(ContentSection $content_section)
    {
        return view('admin.content-sections.show', ['contentSection' => $content_section]);
    }

    public function edit(ContentSection $content_section)
    {
        return view('admin.content-sections.edit', ['contentSection' => $content_section]);
    }

    public function update(UpdateContentSectionRequest $request, ContentSection $content_section)
    {
        $content_section->update($request->validated());

        return redirect()->route('admin.content-sections.index')->with('success', 'Section updated.');
    }

    public function destroy(ContentSection $content_section)
    {
        $content_section->delete();

        return redirect()->route('admin.content-sections.index')->with('success', 'Section deleted.');
    }
}
