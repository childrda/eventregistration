<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit agenda item</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.agenda-items.update', $agenda_item) }}" enctype="multipart/form-data" class="admin-card max-w-2xl space-y-4">
            @csrf @method('PUT')
            @include('admin.agenda-items._form', ['agenda_item' => $agenda_item])
            <button type="submit" class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>
