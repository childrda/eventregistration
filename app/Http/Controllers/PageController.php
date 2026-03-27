<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function what()
    {
        return $this->showBySlug('what');
    }

    public function whenWhere()
    {
        $settings = SiteSetting::query()->firstOrFail();
        return view('public.when-where', compact('settings'));
    }

    public function faq()
    {
        $settings = SiteSetting::query()->firstOrFail();
        $faqs = Faq::query()->where('is_active', true)->orderBy('sort_order')->paginate(20);
        return view('public.faq', compact('settings', 'faqs'));
    }

    public function agenda()
    {
        $settings = SiteSetting::query()->firstOrFail();
        abort_if(blank($settings->agenda_html) && blank($settings->agenda_url), 404);
        return view('public.agenda', compact('settings'));
    }

    protected function showBySlug(string $slug)
    {
        $settings = SiteSetting::query()->firstOrFail();
        $page = Page::query()->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.page', compact('settings', 'page'));
    }
}
