<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Content Section</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.content-sections.update', $contentSection) }}" class="admin-card space-y-3 max-w-2xl">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <input name="section_key" class="admin-input" value="{{ old('section_key', $contentSection->section_key) }}" />
            <input name="title" class="admin-input" value="{{ old('title', $contentSection->title) }}" />
            <input name="subtitle" class="admin-input" value="{{ old('subtitle', $contentSection->subtitle) }}" />
            <textarea name="body" class="admin-input" rows="5">{{ old('body', $contentSection->body) }}</textarea>
            <input name="button_text" class="admin-input" value="{{ old('button_text', $contentSection->button_text) }}" />
            <input name="button_url" class="admin-input" value="{{ old('button_url', $contentSection->button_url) }}" />
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', $contentSection->sort_order) }}" />
            <label><input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $contentSection->is_enabled))> Enabled</label>
            <button class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>

