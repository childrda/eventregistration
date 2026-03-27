<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add Speaker</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.speakers.store') }}" class="admin-card space-y-3 max-w-2xl" enctype="multipart/form-data">
            @csrf
            @include('admin.partials.form-errors')
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Name</label>
                <input name="name" class="admin-input" placeholder="Name" value="{{ old('name') }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Title</label>
                <input name="title" class="admin-input" placeholder="Title" value="{{ old('title') }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Subtitle (optional)</label>
                <input name="subtitle" class="admin-input" placeholder="Subtitle" value="{{ old('subtitle') }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Bio</label>
                <textarea name="bio" class="admin-input" rows="5" placeholder="Bio">{{ old('bio') }}</textarea>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Speaker Photo (optional)</label>
                <input name="image_path" type="file" accept=".jpg,.jpeg,.png,.webp" class="admin-input" />
                <p class="mt-1 text-xs text-slate-500">Accepted: JPG, PNG, WEBP. Max size: 2MB.</p>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">External Link URL (optional)</label>
                <input name="external_link" class="admin-input" placeholder="External link URL" value="{{ old('external_link') }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Link Label (optional)</label>
                <input name="link_label" class="admin-input" placeholder="Link label" value="{{ old('link_label') }}" />
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Sort Order</label>
                <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', 0) }}" />
            </div>
            <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured'))> Featured</label>
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Active</label>
            <button class="admin-btn">Create</button>
        </form>
    </div>
</x-app-layout>

