@extends('layouts.public')

@section('content')
<section class="container-wide pt-16">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <p class="text-xs font-bold uppercase tracking-[0.25em] text-cyan-300">{{ $settings->event_name }} {{ $settings->event_year }}</p>
        <h1 class="mt-4 max-w-4xl text-4xl font-black leading-tight text-white md:text-6xl">{{ $settings->hero_heading }}</h1>
        <p class="section-subtitle text-lg">{{ $settings->hero_subheading }}</p>
        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('public.register') }}" class="btn-primary">{{ $settings->hero_cta_text }}</a>
            @if($settings->hasAgendaContent())
                <a href="{{ route('public.agenda') }}" class="btn-secondary">{{ $settings->agenda_button_text }}</a>
            @endif
        </div>
    </div>
</section>

<section class="container-wide py-16">
    <h2 class="section-title">Featured Speakers & Presenters</h2>
    <p class="section-subtitle">Learn from leaders bringing practical K-12 cyber strategies to district teams.</p>
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($speakers->take(6) as $speaker)
            <article class="glass-panel p-6">
                @if($speaker->photo_url)
                    <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}" class="mx-auto mb-4 h-[300px] w-[250px] rounded-lg object-cover">
                @endif
                <h3 class="text-xl font-bold text-white">{{ $speaker->name }}</h3>
                <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-cyan-300">{{ $speaker->title }}</p>
                @if($speaker->subtitle)<p class="mt-1 text-sm text-slate-400">{{ $speaker->subtitle }}</p>@endif
                <p class="mt-4 text-sm text-slate-300">{{ $speaker->bio }}</p>
            </article>
        @empty
            <p class="text-slate-400">Speakers will be announced soon.</p>
        @endforelse
    </div>
</section>

<section class="container-wide pb-16">
    <div class="grid gap-6 md:grid-cols-2">
        <article class="glass-panel p-8">
            <h3 class="text-2xl font-bold text-white">{{ $sections['highlights']->title ?? 'Conference Highlights' }}</h3>
            <p class="mt-3 text-slate-300">{{ $sections['highlights']->body ?? 'Hands-on sessions, peer networking, and practical district implementation guidance.' }}</p>
        </article>
        <article class="glass-panel p-8">
            <h3 class="text-2xl font-bold text-white">When & Where</h3>
            <p class="mt-3 text-slate-300">{{ $settings->venue_name }}</p>
            <p class="text-slate-400">{{ $settings->venue_address_line_1 }}, {{ $settings->venue_city }}, {{ $settings->venue_state }} {{ $settings->venue_zip }}</p>
            <p class="mt-3 font-semibold text-cyan-300">
                {{ $settings->event_start_date?->format('F j, Y') }}
                @if($settings->event_end_date && !$settings->event_start_date?->isSameDay($settings->event_end_date))
                    - {{ $settings->event_end_date?->format('F j, Y') }}
                @endif
                @if($settings->event_start_time || $settings->event_end_time)
                    <br>
                    {{ $settings->event_start_time ? \Illuminate\Support\Carbon::createFromFormat('H:i:s', $settings->event_start_time)->format('g:i A') : '' }}
                    @if($settings->event_end_time)
                        - {{ \Illuminate\Support\Carbon::createFromFormat('H:i:s', $settings->event_end_time)->format('g:i A') }}
                    @endif
                @endif
            </p>
        </article>
    </div>
</section>

<section class="container-wide pb-16">
    <div class="glass-panel p-8 text-center">
        <h3 class="text-3xl font-black text-white">{{ $sections['agenda_cta']->title ?? 'View the Agenda' }}</h3>
        <p class="mt-3 text-slate-300">{{ $sections['agenda_cta']->body ?? 'See keynotes, breakouts, and planning sessions.' }}</p>
        @if($settings->hasAgendaContent())
            <a href="{{ route('public.agenda') }}" class="btn-primary mt-6">{{ $settings->agenda_button_text }}</a>
        @endif
    </div>
</section>

<section class="container-wide pb-16">
    <h2 class="section-title">FAQ Preview</h2>
    <div class="mt-8 grid gap-4">
        @foreach($faqs as $faq)
            <article class="glass-panel p-5">
                <h3 class="font-semibold text-white">{{ $faq->question }}</h3>
                <p class="mt-2 text-sm text-slate-300">{{ $faq->answer }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="container-wide pb-16">
    <h2 class="section-title">What Attendees Say</h2>
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($testimonials->take(3) as $testimonial)
            <article class="glass-panel p-6">
                <p class="text-slate-200">"{{ $testimonial->quote }}"</p>
                <p class="mt-4 text-sm font-semibold text-cyan-300">{{ $testimonial->person_name }}</p>
                @if($testimonial->person_title)<p class="text-xs text-slate-400">{{ $testimonial->person_title }}</p>@endif
            </article>
        @endforeach
    </div>
</section>

<section class="container-wide pb-20">
    <div class="rounded-2xl border border-cyan-400/40 bg-cyan-500/10 p-10 text-center">
        <h3 class="text-3xl font-black text-white">Ready to Join Virginia Cybercon?</h3>
        <p class="mt-3 text-slate-300">Reserve your spot and get your district represented.</p>
        <a href="{{ route('public.register') }}" class="btn-primary mt-6">{{ $settings->registration_button_text }}</a>
    </div>
</section>
@endsection

