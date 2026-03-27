@extends('layouts.public')
@section('content')
<section class="container-wide py-24">
    <div class="mx-auto max-w-2xl rounded-2xl border border-emerald-400/40 bg-emerald-500/10 p-10 text-center shadow-xl shadow-slate-950/40">
        <h1 class="text-4xl font-black text-white">Registration Submitted</h1>
        <p class="mt-4 text-slate-200">Thank you for registering. A confirmation email has been sent to your address.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('public.home') }}" class="btn-secondary">Back to Home</a>
            <a href="{{ route('public.faq') }}" class="btn-primary">View FAQ</a>
        </div>
    </div>
</section>
@endsection

