@extends('layouts.public')
@section('content')
<section class="container-wide py-16">
    <article class="mx-auto max-w-5xl glass-panel p-8 md:p-12">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-300">{{ $settings->event_name }} {{ $settings->event_year }}</p>
        <h1 class="mt-3 section-title">{{ $page->title }}</h1>
        @if($page->intro)
            <p class="section-subtitle text-lg">{{ $page->intro }}</p>
        @endif
        <div class="prose prose-invert mt-8 max-w-none prose-headings:text-white prose-p:text-slate-300">{!! nl2br(e($page->body)) !!}</div>
    </article>
</section>
@endsection

