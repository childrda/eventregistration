<x-app-layout><x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Testimonial</h2></x-slot><div class="p-6"><div class="rounded border bg-white p-4"><p class="italic">"{{ $testimonial->quote }}"</p><p class="mt-2 font-semibold">{{ $testimonial->person_name }}</p></div></div></x-app-layout>

