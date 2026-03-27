<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Speaker</h2></x-slot>
    <div class="p-6">
        <div class="rounded border bg-white p-4">
            <p><strong>{{ $speaker->name }}</strong></p>
            <p>{{ $speaker->title }}</p>
            <p class="mt-2">{{ $speaker->bio }}</p>
        </div>
    </div>
</x-app-layout>

