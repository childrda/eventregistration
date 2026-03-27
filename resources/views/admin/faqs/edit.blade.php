<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit FAQ</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="admin-card space-y-3 max-w-2xl">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <input name="question" class="admin-input" value="{{ old('question', $faq->question) }}" />
            <textarea name="answer" class="admin-input" rows="5">{{ old('answer', $faq->answer) }}</textarea>
            <input name="sort_order" type="number" class="admin-input" value="{{ old('sort_order', $faq->sort_order) }}" />
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->is_active))> Active</label>
            <button class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>

