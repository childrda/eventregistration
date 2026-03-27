<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Registration Detail</h2></x-slot>
    <div class="p-6 space-y-4">
        @if(session('success'))<div class="rounded bg-emerald-100 p-3">{{ session('success') }}</div>@endif
        <div class="rounded border bg-white p-4">
            <p><strong>Name:</strong> {{ $registration->first_name }} {{ $registration->last_name }}</p>
            <p><strong>Email:</strong> {{ $registration->email }}</p>
            <p><strong>District:</strong> {{ $registration->district_name }}</p>
            <p><strong>Role:</strong> {{ $registration->title_role }}</p>
            <p><strong>Lunch:</strong> {{ optional($registration->lunchOption)->name }}</p>
            <p><strong>T-shirt:</strong> {{ optional($registration->tshirtSize)->name }}</p>
            <p><strong>Status:</strong> {{ $registration->status }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.registrations.edit', $registration) }}" class="rounded bg-indigo-600 px-4 py-2 text-white">Edit</a>
            <form method="POST" action="{{ route('admin.registrations.resend-confirmation', $registration) }}">@csrf<button class="rounded bg-slate-900 px-4 py-2 text-white">Resend Confirmation</button></form>
        </div>
        <div class="rounded border bg-white p-4">
            <h3 class="font-semibold">Email Log</h3>
            <ul class="mt-2 space-y-1 text-sm">
                @foreach($registration->sentEmails as $email)
                    <li>{{ $email->created_at }} - {{ $email->status }} - {{ $email->subject }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>

