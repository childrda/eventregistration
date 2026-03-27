<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add Content Section</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.content-sections.store') }}" class="admin-card space-y-3 max-w-2xl">
            @csrf
            @include('admin.partials.form-errors')
            <input name="section_key" class="admin-input" value="{{ old('section_key') }}" placeholder="section_key" />
            <input name="title" class="admin-input" value="{{ old('title') }}" placeholder="Title" />
            <input name="subtitle" class="admin-input" value="{{ old('subtitle') }}" placeholder="Subtitle" />
            <textarea name="body" class="admin-input" rows="5" placeholder="Body">{{ old('body') }}</textarea>
            <input name="button_text" class="admin-input" value="{{ old('button_text') }}" placeholder="Button text" />
            <input name="button_url" class="admin-input" value="{{ old('button_url') }}" placeholder="Button URL" />
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', 0) }}" />
            <label><input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', true))> Enabled</label>
            <button class="admin-btn">Create</button>
        </form>
    </div>
</x-app-layout>

