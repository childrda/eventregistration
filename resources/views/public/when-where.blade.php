@extends('layouts.public')

@section('content')
<section class="container-wide py-16">
    <article class="mx-auto max-w-5xl glass-panel p-8 md:p-12">
        <h1 class="section-title">When &amp; Where</h1>
        <p class="mt-6 text-4xl font-semibold text-white">{{ $settings->venue_name }}</p>
        <p class="mt-2 text-2xl text-slate-400">
            {{ $settings->venue_address_line_1 }}
            @if($settings->venue_address_line_2), {{ $settings->venue_address_line_2 }}@endif,
            {{ $settings->venue_city }}, {{ $settings->venue_state }} {{ $settings->venue_zip }}
        </p>
        <p class="mt-8 text-4xl font-bold text-cyan-300">
            {{ $settings->event_start_date?->format('F j, Y') }}
            @if($settings->event_end_date && !$settings->event_start_date?->isSameDay($settings->event_end_date))
                - {{ $settings->event_end_date?->format('F j, Y') }}
            @endif
        </p>
        @if($settings->event_start_time || $settings->event_end_time)
            <p class="mt-2 text-4xl font-bold text-cyan-300">
                {{ $settings->event_start_time ? \Illuminate\Support\Carbon::createFromFormat('H:i:s', $settings->event_start_time)->format('g:i A') : '' }}
                @if($settings->event_end_time)
                    - {{ \Illuminate\Support\Carbon::createFromFormat('H:i:s', $settings->event_end_time)->format('g:i A') }}
                @endif
            </p>
        @endif
    </article>
</section>
@endsection

