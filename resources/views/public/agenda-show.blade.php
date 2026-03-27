@extends('layouts.public')

@section('content')
<section class="container-wide py-12 md:py-16">
    <nav class="mb-8 text-sm text-cyan-400">
        <a href="{{ route('public.agenda') }}" class="hover:text-cyan-300">← Back to agenda</a>
    </nav>

    <article class="glass-panel mx-auto max-w-3xl p-8 md:p-12">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-300">Session</p>
        <h1 class="mt-3 text-3xl font-black text-white md:text-4xl">{{ $item->title }}</h1>
        <p class="mt-4 text-slate-400">
            {{ \Illuminate\Support\Carbon::parse($item->start_time)->format('g:i A') }}
            –
            {{ \Illuminate\Support\Carbon::parse($item->end_time)->format('g:i A') }}
        </p>

        @if(filled($item->detail_text))
            <div class="prose prose-invert prose-p:text-slate-300 mt-8 max-w-none">
                {!! nl2br(e($item->detail_text)) !!}
            </div>
        @endif

        @if($item->documentUrl())
            <div class="mt-8">
                <a href="{{ $item->documentUrl() }}" class="btn-primary inline-flex items-center gap-2" target="_blank" rel="noopener">
                    Download document
                </a>
            </div>
        @endif

        @if(! filled($item->detail_text) && ! $item->documentUrl())
            <p class="mt-8 text-slate-400">No additional materials for this session.</p>
        @endif
    </article>
</section>
@endsection
