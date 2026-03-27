<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit event: {{ $event->event_name }}</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="admin-card max-w-xl space-y-4">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <div>
                <label class="block text-sm font-medium text-slate-700">Slug</label>
                <input name="slug" class="admin-input mt-1 w-full" value="{{ old('slug', $event->slug) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Sort order</label>
                <input type="number" name="sort_order" class="admin-input mt-1 w-full" value="{{ old('sort_order', $event->sort_order) }}" min="0">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $event->is_enabled))>
                Event enabled (visible on public site when selected)
            </label>
            <button type="submit" class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>
