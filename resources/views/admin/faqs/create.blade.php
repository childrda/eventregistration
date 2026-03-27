<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add FAQ</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.faqs.store') }}" class="admin-card space-y-3 max-w-2xl">
            @csrf
            @include('admin.partials.form-errors')
            <input name="question" class="admin-input" value="{{ old('question') }}" placeholder="Question" />
            <textarea name="answer" class="admin-input" rows="5" placeholder="Answer">{{ old('answer') }}</textarea>
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', 0) }}" />
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Active</label>
            <button class="admin-btn">Create</button>
        </form>
    </div>
</x-app-layout>

