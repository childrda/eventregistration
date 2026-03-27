<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Testimonial</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" class="admin-card space-y-3 max-w-2xl">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <textarea name="quote" class="admin-input" rows="5">{{ old('quote', $testimonial->quote) }}</textarea>
            <input name="person_name" class="admin-input" value="{{ old('person_name', $testimonial->person_name) }}" />
            <input name="person_title" class="admin-input" value="{{ old('person_title', $testimonial->person_title) }}" />
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', $testimonial->sort_order) }}" />
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->is_active))> Active</label>
            <button class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>

