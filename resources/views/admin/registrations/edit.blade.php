<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Registration</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.registrations.update', $registration) }}" class="admin-card space-y-4 max-w-xl">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <input class="admin-input" value="{{ $registration->email }}" disabled />
            <select name="status" class="admin-input">
                @foreach(['registered','waitlist','cancelled'] as $status)<option value="{{ $status }}" @selected($registration->status===$status)>{{ ucfirst($status) }}</option>@endforeach
            </select>
            <textarea name="notes" class="admin-input" rows="5" placeholder="Admin notes">{{ old('notes', $registration->notes) }}</textarea>
            <button class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>

