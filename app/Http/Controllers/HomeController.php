<?php

namespace App\Http\Controllers;

use App\Models\ContentSection;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Speaker;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $enabled = Event::query()->enabled()->orderBy('sort_order')->orderBy('id')->get();

        if ($enabled->isEmpty()) {
            abort(503, 'No events are available.');
        }

        if ($enabled->count() > 1 && ! session('public_event_id')) {
            return view('public.select-event', ['events' => $enabled]);
        }

        $eventId = (int) session('public_event_id');
        $settings = Event::query()->enabled()->whereKey($eventId)->firstOrFail();

        $speakers = Speaker::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $faqs = Faq::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        $testimonials = Testimonial::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $sections = ContentSection::query()
            ->where('event_id', $eventId)
            ->where('is_enabled', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        return view('public.home', compact('settings', 'speakers', 'faqs', 'testimonials', 'sections'));
    }
}
