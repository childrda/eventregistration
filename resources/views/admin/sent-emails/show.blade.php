<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Sent Email Detail</h2></x-slot>
    <div class="p-6 space-y-4">
        <div class="rounded border bg-white p-4">
            <p><strong>To:</strong> {{ $sentEmail->to_email }}</p>
            <p><strong>Status:</strong> {{ $sentEmail->status }}</p>
            <p><strong>Subject:</strong> {{ $sentEmail->subject }}</p>
            <p><strong>Sent at:</strong> {{ $sentEmail->sent_at }}</p>
            @if($sentEmail->error_message)<p><strong>Error:</strong> {{ $sentEmail->error_message }}</p>@endif
        </div>
        <div class="rounded border bg-white p-4">
            <h3 class="font-semibold">HTML Body</h3>
            <div class="prose mt-2 max-w-none">{!! $sentEmail->html_body ?: '<em>No HTML body</em>' !!}</div>
        </div>
        <div class="rounded border bg-white p-4">
            <h3 class="font-semibold">Text Body</h3>
            <pre class="mt-2 whitespace-pre-wrap text-sm">{{ $sentEmail->text_body }}</pre>
        </div>
    </div>
</x-app-layout>

