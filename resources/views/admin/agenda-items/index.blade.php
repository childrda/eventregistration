<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Agenda</h2></x-slot>
    <div class="p-6 space-y-4">
        <p class="text-sm text-slate-600">Add sessions with start and end times. Use the same start time for multiple rows to show concurrent sessions (e.g. two breakouts). Lower sort order appears first within the same time.</p>
        <a href="{{ route('admin.agenda-items.create') }}" class="admin-btn">Add agenda item</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Start</th>
                        <th class="p-2 text-left">End</th>
                        <th class="p-2 text-left">Title</th>
                        <th class="p-2 text-left">Sort</th>
                        <th class="p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr class="border-t">
                            <td class="p-2 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($item->start_time)->format('g:i A') }}</td>
                            <td class="p-2 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($item->end_time)->format('g:i A') }}</td>
                            <td class="p-2">{{ $item->title }}</td>
                            <td class="p-2">{{ $item->sort_order }}</td>
                            <td class="p-2 text-right whitespace-nowrap">
                                <a class="text-indigo-600" href="{{ route('admin.agenda-items.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.agenda-items.destroy', $item) }}" class="inline" onsubmit="return confirm('Remove this agenda item?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</x-app-layout>
