<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add T-Shirt Size</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.tshirt-sizes.store') }}" class="admin-card space-y-3 max-w-xl">
            @csrf
            @include('admin.partials.form-errors')
            <input name="name" class="admin-input" value="{{ old('name') }}" placeholder="Size name" />
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', $nextSortOrder) }}" />
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Active</label>
            <button class="admin-btn">Create</button>
        </form>
    </div>
</x-app-layout>

