<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Speaker</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.speakers.update', $speaker) }}" class="admin-card space-y-3 max-w-2xl" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Name</label>
                <input name="name" class="admin-input" value="{{ old('name', $speaker->name) }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Title</label>
                <input name="title" class="admin-input" value="{{ old('title', $speaker->title) }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Subtitle (optional)</label>
                <input name="subtitle" class="admin-input" value="{{ old('subtitle', $speaker->subtitle) }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Bio</label>
                <textarea name="bio" class="admin-input" rows="5">{{ old('bio', $speaker->bio) }}</textarea>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Photo (optional)</label>
                @if($speaker->photo_url)
                    <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}" class="mb-2 h-24 w-24 rounded object-cover">
                @endif
                <input name="image_path" type="file" accept=".jpg,.jpeg,.png,.webp" class="admin-input" />
                <p class="mt-1 text-xs text-slate-500">Upload a new file to replace current photo. Max size: 2MB.</p>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">External Link URL (optional)</label>
                <input name="external_link" class="admin-input" value="{{ old('external_link', $speaker->external_link) }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Link Label (optional)</label>
                <input name="link_label" class="admin-input" value="{{ old('link_label', $speaker->link_label) }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Sort Order</label>
                <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', $speaker->sort_order) }}" />
            </div>
            <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $speaker->is_featured))> Featured</label>
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $speaker->is_active))> Active</label>
            <div class="flex gap-2"><button class="admin-btn">Save</button></div>
        </form>
    </div>
</x-app-layout>

