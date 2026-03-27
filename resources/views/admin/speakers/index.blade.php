<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Speakers</h2></x-slot>
    <div class="p-6 space-y-4">
        <a href="{{ route('admin.speakers.create') }}" class="admin-btn">Add Speaker</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Photo</th><th class="p-2 text-left">Name</th><th class="p-2">Title</th><th class="p-2">Featured</th><th class="p-2"></th></tr></thead>
                <tbody>
                    @foreach($speakers as $speaker)
                        <tr class="border-t">
                            <td class="p-2">
                                @if($speaker->photo_url)
                                    <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}" class="h-12 w-12 rounded object-cover">
                                @else
                                    <div class="h-12 w-12 rounded bg-slate-200"></div>
                                @endif
                            </td>
                            <td class="p-2">{{ $speaker->name }}</td>
                            <td class="p-2">{{ $speaker->title }}</td>
                            <td class="p-2">{{ $speaker->is_featured ? 'Yes' : 'No' }}</td>
                            <td class="p-2 text-right">
                                <a href="{{ route('admin.speakers.edit', $speaker) }}" class="text-indigo-600">Edit</a>
                                <form method="POST" action="{{ route('admin.speakers.destroy', $speaker) }}" class="inline" onsubmit="return confirm('Delete this speaker?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $speakers->links() }}
    </div>
</x-app-layout>

