@extends('layouts.public')

{{-- Pastel blocks + bold dark text. Concurrent sessions advance the palette (e.g. mint + teal). --}}
@php
    $palette = [
        'bg-[#fef9c3]',
        'bg-[#ffedd5]',
        'bg-[#fed7aa]',
        'bg-[#fecaca]',
        'bg-[#e9d5ff]',
        'bg-[#fce7f3]',
        'bg-[#bbf7d0]',
        'bg-[#99f6e4]',
    ];
    $colorIdx = 0;
@endphp

@section('content')
<section class="container-wide py-12 md:py-16">
    <h1 class="mb-8 text-4xl font-black tracking-tight text-white md:text-5xl lg:mb-10">Agenda</h1>

    {{-- Two-column grid: time | colored blocks. Row heights stay aligned. Right stack has unified rounding on the outer edge only. --}}
    <div
        class="mx-auto w-full max-w-4xl"
        style="display: grid; grid-template-columns: 5.25rem minmax(0, 1fr); grid-auto-rows: minmax(3.75rem, auto);"
    >
        @foreach($rows as $slotItems)
            @php
                $first = $slotItems->first();
                $startLabel = \Illuminate\Support\Carbon::parse($first->start_time)->format('g:i');
            @endphp

            {{-- Time column --}}
            <div
                @class([
                    'flex items-center py-3 pr-3 text-[15px] font-medium tabular-nums text-slate-400',
                    'border-b border-dotted border-slate-500/60' => ! $loop->last,
                ])
            >
                {{ $startLabel }}
            </div>

            {{-- Session column: blocks stack with no gap; outer right corners rounded on the stack --}}
            <div
                @class([
                    'flex min-h-[3.75rem] p-0',
                    'border-b border-dotted border-slate-500/60' => ! $loop->last,
                    'rounded-tr-2xl overflow-hidden' => $loop->first,
                    'rounded-br-2xl overflow-hidden' => $loop->last,
                ])
            >
                <div class="flex min-h-[3.75rem] w-full">
                    @foreach($slotItems as $item)
                        @php
                            $bg = $palette[$colorIdx % count($palette)];
                            $colorIdx++;
                        @endphp
                        <a
                            href="{{ route('public.agenda.show', $item) }}"
                            class="{{ $bg }} flex min-h-[3.75rem] flex-1 items-center px-5 py-4 text-left text-base font-bold leading-snug text-gray-900 antialiased transition hover:brightness-[0.97] focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950 {{ $slotItems->count() > 1 && ! $loop->first ? 'border-l border-gray-900/15' : '' }}"
                        >
                            <span class="text-gray-900">{{ $item->title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <p class="mt-10 text-center text-sm text-slate-500">Tap a session for details and materials.</p>
</section>
@endsection
