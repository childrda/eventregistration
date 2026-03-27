<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add Testimonial</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" class="admin-card space-y-3 max-w-2xl">
            @csrf
            @include('admin.partials.form-errors')
            <textarea name="quote" class="admin-input" rows="5" placeholder="Quote">{{ old('quote') }}</textarea>
            <input name="person_name" class="admin-input" value="{{ old('person_name') }}" placeholder="Person name" />
            <input name="person_title" class="admin-input" value="{{ old('person_title') }}" placeholder="Person title" />
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', 0) }}" />
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Active</label>
            <button class="admin-btn">Create</button>
        </form>
    </div>
</x-app-layout>

