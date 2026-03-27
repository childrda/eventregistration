<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::query()->forAdminEvent()->orderBy('slug')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }
}
