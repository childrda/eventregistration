<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Events</h2></x-slot>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="rounded-lg border border-emerald-300 bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>@endif
        <p class="text-sm text-slate-600">Super admins can add events and enable or disable them. Disabled events are hidden from the public site.</p>
        <a href="{{ route('admin.events.create') }}" class="admin-btn inline-block">Add event</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Slug</th>
                        <th class="p-2 text-left">Enabled</th>
                        <th class="p-2 text-left">Sort</th>
                        <th class="p-2 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($events as $ev)
                    <tr class="border-t">
                        <td class="p-2 font-medium">{{ $ev->event_name }}</td>
                        <td class="p-2 text-slate-600">{{ $ev->slug }}</td>
                        <td class="p-2">{{ $ev->is_enabled ? 'Yes' : 'No' }}</td>
                        <td class="p-2">{{ $ev->sort_order }}</td>
                        <td class="p-2"><a href="{{ route('admin.events.edit', $ev) }}" class="text-cyan-700 hover:underline">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $events->links() }}
    </div>
</x-app-layout>
