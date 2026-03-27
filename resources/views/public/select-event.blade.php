@extends('layouts.public')

@section('content')
<section class="container-wide pt-16 pb-24">
    <div class="glass-panel mx-auto max-w-2xl p-10 text-center">
        <h1 class="text-3xl font-black text-white md:text-4xl">Choose an event</h1>
        <p class="mt-3 text-slate-300">Multiple conferences are available. Select one to view the site and register.</p>
        @if(session('info'))
            <p class="mt-4 rounded-lg border border-amber-500/40 bg-amber-500/10 px-4 py-2 text-sm text-amber-100">{{ session('info') }}</p>
        @endif
        <ul class="mt-10 space-y-4 text-left">
            @foreach($events as $event)
                <li>
                    <form method="POST" action="{{ route('public.select-event') }}" class="block">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <button type="submit" class="glass-panel w-full p-6 text-left transition hover:border-cyan-500/50">
                            <span class="text-lg font-bold text-white">{{ $event->event_name }}</span>
                            <span class="mt-1 block text-sm text-cyan-300">{{ $event->event_year }} · {{ $event->venue_city }}, {{ $event->venue_state }}</span>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
