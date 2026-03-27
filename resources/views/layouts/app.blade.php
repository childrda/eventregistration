<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800">
        <div class="min-h-screen bg-gray-100 text-slate-800">
            @include('layouts.navigation')

            <div class="mx-auto flex w-full max-w-7xl gap-6 px-4 py-6 sm:px-6 lg:px-8">
                @if (request()->routeIs('admin.*'))
                    <aside class="hidden w-64 shrink-0 lg:block">
                        <div class="admin-sidebar rounded-xl border border-slate-200 bg-white p-4 text-slate-700 shadow-sm">
                            <p class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-500">Admin Navigation</p>
                            <nav class="space-y-1 text-sm">
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.dashboard') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.site-settings.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.site-settings.edit') }}">Site Settings</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.pages.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.pages.index') }}">Pages</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.users.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.users.index') }}">Admin Users</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.registrations.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.registrations.index') }}">Registrations</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.speakers.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.speakers.index') }}">Speakers</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.faqs.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.faqs.index') }}">FAQs</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.testimonials.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.content-sections.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.content-sections.index') }}">Content Sections</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.lunch-options.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.lunch-options.index') }}">Lunch Options</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.tshirt-sizes.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.tshirt-sizes.index') }}">T-Shirt Sizes</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.email-templates.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.email-templates.index') }}">Email Templates</a>
                                <a class="block rounded px-3 py-2 hover:bg-slate-100 {{ request()->routeIs('admin.sent-emails.*') ? 'active bg-slate-100 font-semibold' : '' }}" href="{{ route('admin.sent-emails.index') }}">Sent Emails</a>
                            </nav>
                        </div>
                    </aside>
                @endif

                <main class="min-w-0 flex-1 text-slate-800">
                    @isset($header)
                        <header class="mb-6 rounded-xl border border-slate-200 bg-white px-6 py-4 shadow-sm">
                            {{ $header }}
                        </header>
                    @endisset
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
