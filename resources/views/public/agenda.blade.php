@extends('layouts.public')

@section('content')
<section class="container-wide py-16">
    <article class="mx-auto max-w-5xl glass-panel p-8 md:p-12">
        <h1 class="section-title">Agenda</h1>
        @if(!empty($settings->agenda_html))
            <div class="prose prose-invert mt-6 max-w-none">{!! $settings->agenda_html !!}</div>
        @elseif(!empty($settings->agenda_url))
            <p class="mt-4 text-slate-300">The agenda is hosted externally.</p>
            <a href="{{ $settings->agenda_url }}" class="btn-primary mt-6">{{ $settings->agenda_button_text }}</a>
        @endif
    </article>
</section>
@endsection

