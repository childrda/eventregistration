<?php

namespace App\Http\Controllers;

use App\Models\ContentSection;
use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\Speaker;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::query()->firstOrFail();
        $speakers = Speaker::query()->where('is_active', true)->orderBy('sort_order')->get();
        $faqs = Faq::query()->where('is_active', true)->orderBy('sort_order')->limit(5)->get();
        $testimonials = Testimonial::query()->where('is_active', true)->orderBy('sort_order')->get();
        $sections = ContentSection::query()->where('is_enabled', true)->orderBy('sort_order')->get()->keyBy('section_key');

        return view('public.home', compact('settings', 'speakers', 'faqs', 'testimonials', 'sections'));
    }
}
