<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Template Preview</h2></x-slot>
    <div class="p-6 space-y-4">
        <div class="rounded border bg-white p-4">
            <p><strong>Name:</strong> {{ $emailTemplate->name }}</p>
            <p><strong>Subject:</strong> {{ $emailTemplate->subject }}</p>
        </div>
        <div class="rounded border bg-white p-4">
            <h3 class="font-semibold">Preview (sample merged content)</h3>
            <div class="prose mt-2 max-w-none">{!! $preview ?: 'No sample data available yet.' !!}</div>
        </div>
    </div>
</x-app-layout>

