<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Pages</h2></x-slot>
    <div class="p-6 space-y-4">
        @if(session('success'))<div class="rounded-lg border border-emerald-300 bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>@endif
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Slug</th>
                        <th class="p-2 text-left">Title</th>
                        <th class="p-2 text-left">Active</th>
                        <th class="p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr class="border-t">
                        <td class="p-2">{{ $page->slug }}</td>
                        <td class="p-2">{{ $page->title }}</td>
                        <td class="p-2">{{ $page->is_active ? 'Yes' : 'No' }}</td>
                        <td class="p-2"><a href="{{ route('admin.pages.edit', $page) }}" class="text-indigo-600">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $pages->links() }}
    </div>
</x-app-layout>

