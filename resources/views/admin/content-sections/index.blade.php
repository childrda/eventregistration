<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Content Sections</h2></x-slot>
    <div class="p-6 space-y-4">
        <a href="{{ route('admin.content-sections.create') }}" class="admin-btn">Add Section</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Key</th><th class="p-2 text-left">Title</th><th class="p-2"></th></tr></thead>
                <tbody>
                    @foreach($contentSections as $section)
                        <tr class="border-t">
                            <td class="p-2">{{ $section->section_key }}</td>
                            <td class="p-2">{{ $section->title }}</td>
                            <td class="p-2 text-right">
                                <a href="{{ route('admin.content-sections.edit', $section) }}" class="text-indigo-600">Edit</a>
                                <form method="POST" action="{{ route('admin.content-sections.destroy', $section) }}" class="inline" onsubmit="return confirm('Delete this section?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $contentSections->links() }}
    </div>
</x-app-layout>

