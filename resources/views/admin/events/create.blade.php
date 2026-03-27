<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add event</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.events.store') }}" class="admin-card max-w-xl space-y-4">
            @csrf
            @include('admin.partials.form-errors')
            <div>
                <label class="block text-sm font-medium text-slate-700">URL slug</label>
                <input name="slug" class="admin-input mt-1 w-full" value="{{ old('slug') }}" placeholder="e.g. richmond-2026" required>
                <p class="mt-1 text-xs text-slate-500">Lowercase letters, numbers, and hyphens only.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Event display name</label>
                <input name="event_name" class="admin-input mt-1 w-full" value="{{ old('event_name') }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Copy setup from</label>
                <select name="copy_from_event_id" class="admin-input mt-1 w-full">
                    @foreach($sourceEvents as $ev)
                        <option value="{{ $ev->id }}" @selected((int)old('copy_from_event_id', session('admin_event_id')) === $ev->id)>{{ $ev->event_name }} ({{ $ev->slug }})</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-500">Pages, email templates, FAQs, lunch options, shirt sizes, testimonials, and content blocks are copied. Speakers and registrations are not.</p>
            </div>
            <button type="submit" class="admin-btn">Create event</button>
        </form>
    </div>
</x-app-layout>
