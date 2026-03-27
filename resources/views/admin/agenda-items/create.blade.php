<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Add agenda item</h2></x-slot>
    <div class="p-6">
        <form method="POST" action="{{ route('admin.agenda-items.store') }}" enctype="multipart/form-data" class="admin-card max-w-2xl space-y-4">
            @csrf
            @include('admin.agenda-items._form', [
                'agenda_item' => null,
                'defaultStartTime' => $defaultStartTime,
                'defaultEndTime' => $defaultEndTime,
                'defaultSortOrder' => $defaultSortOrder,
            ])
            <button type="submit" class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>
