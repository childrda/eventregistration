<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFaqRequest;
use App\Http\Requests\Admin\UpdateFaqRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::query()->forAdminEvent()->orderBy('sort_order')->paginate(20);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(StoreFaqRequest $request)
    {
        Faq::query()->create([
            ...$request->validated(),
            'event_id' => session('admin_event_id'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }
}
