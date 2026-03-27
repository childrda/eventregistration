<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Page: {{ $page->slug }}</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="admin-card space-y-4 max-w-4xl">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Title</label>
                <input name="title" class="admin-input" value="{{ old('title', $page->title) }}">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Intro</label>
                <textarea name="intro" rows="3" class="admin-input">{{ old('intro', $page->intro) }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Body</label>
                <textarea name="body" rows="12" class="admin-input">{{ old('body', $page->body) }}</textarea>
            </div>

            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page->is_active))> Active</label>

            <button class="admin-btn">Save Page</button>
        </form>
    </div>
</x-app-layout>

