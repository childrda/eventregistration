<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Faq;
use App\Models\Page;

class PageController extends Controller
{
    public function what()
    {
        return $this->showBySlug('what');
    }

    public function whenWhere()
    {
        $settings = $this->publicEventSettings();

        return view('public.when-where', compact('settings'));
    }

    public function faq()
    {
        $settings = $this->publicEventSettings();
        $eventId = (int) session('public_event_id');
        $faqs = Faq::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(20);

        return view('public.faq', compact('settings', 'faqs'));
    }

    protected function showBySlug(string $slug)
    {
        $settings = $this->publicEventSettings();
        $eventId = (int) session('public_event_id');
        $page = Page::query()
            ->where('event_id', $eventId)
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.page', compact('settings', 'page'));
    }

    protected function publicEventSettings(): Event
    {
        $eventId = (int) session('public_event_id');

        return Event::query()->enabled()->whereKey($eventId)->firstOrFail();
    }
}
