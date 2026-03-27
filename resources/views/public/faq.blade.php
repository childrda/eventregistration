@extends('layouts.public')
@section('content')
<section class="container-wide py-16">
    <div class="mx-auto max-w-5xl">
        <h1 class="section-title">Frequently Asked Questions</h1>
        <p class="section-subtitle">Everything districts ask most before attending Virginia Cybercon.</p>
    </div>
    <div class="mx-auto mt-8 grid max-w-5xl gap-4">
        @foreach($faqs as $faq)
            <article class="glass-panel p-5">
                <h3 class="font-semibold text-white">{{ $faq->question }}</h3>
                <p class="mt-2 text-slate-300">{{ $faq->answer }}</p>
            </article>
        @endforeach
    </div>
    <div class="mx-auto mt-8 max-w-5xl">{{ $faqs->links() }}</div>
</section>
@endsection

