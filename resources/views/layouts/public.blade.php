<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <title>{{ $settings->site_name ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/90 backdrop-blur">
    <div class="container-wide flex items-center justify-between py-4">
        <a href="{{ route('public.home') }}" class="flex items-center gap-3 text-xl font-extrabold tracking-wide text-white">
            <img src="{{ asset('favicon.png') }}" alt="Virginia Cybercon logo" class="h-10 w-10 object-contain">
            <span>{{ $settings->site_name ?? 'VA Cybercon' }}</span>
        </a>
        <div class="flex items-center gap-5 text-sm font-medium text-slate-300">
            <a class="hover:text-cyan-300" href="{{ route('public.what') }}">What</a>
            <a class="hover:text-cyan-300" href="{{ route('public.when-where') }}">When & Where</a>
            @if(($settings->agenda_html ?? null) || ($settings->agenda_url ?? null))
                <a class="hover:text-cyan-300" href="{{ route('public.agenda') }}">Agenda</a>
            @endif
            <a class="hover:text-cyan-300" href="{{ route('public.faq') }}">FAQ</a>
            <a class="hover:text-cyan-300" href="{{ route('public.contact') }}">Contact</a>
            <a href="{{ route('public.register') }}" class="btn-primary !px-4 !py-2">{{ $settings->registration_button_text ?? 'Register' }}</a>
        </div>
    </div>
</nav>
<main>@yield('content')</main>
<footer class="mt-20 border-t border-slate-800 bg-slate-950/90">
    <div class="container-wide py-10 text-center text-sm text-slate-400">{{ $settings->footer_text ?? 'Virginia Cybercon' }}</div>
</footer>
</body>
</html>

