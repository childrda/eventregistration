@extends('layouts.public')
@section('content')
<section class="container-wide py-16">
    <div class="mx-auto grid max-w-5xl gap-8 md:grid-cols-2">
        <article class="glass-panel p-8">
            <h1 class="section-title">Contact</h1>
            <p class="mt-3 text-slate-300">Questions about registration, logistics, or district attendance? Send us a message.</p>
            <div class="mt-8 text-sm text-slate-300">
                <p><span class="font-semibold text-white">Email:</span> {{ $settings->contact_email }}</p>
                @if($settings->contact_phone)
                    <p class="mt-2"><span class="font-semibold text-white">Phone:</span> {{ $settings->contact_phone }}</p>
                @endif
            </div>
        </article>
        <article class="glass-panel p-8">
            @if(session('success'))<p class="mb-4 rounded-lg border border-emerald-400/40 bg-emerald-500/20 p-3 text-emerald-100">{{ session('success') }}</p>@endif
            <form method="POST" action="{{ route('public.contact.store') }}" class="space-y-4">
                @csrf
                <input name="name" value="{{ old('name') }}" placeholder="Name" class="input-dark" />
                <input name="email" value="{{ old('email') }}" placeholder="Email" class="input-dark" />
                <input name="subject" value="{{ old('subject') }}" placeholder="Subject" class="input-dark" />
                <textarea name="message" placeholder="Message" rows="5" class="input-dark">{{ old('message') }}</textarea>
                <button class="btn-primary w-full">Send Message</button>
            </form>
        </article>
    </div>
</section>
@endsection

