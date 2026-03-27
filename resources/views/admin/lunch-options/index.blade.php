<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Lunch Options</h2></x-slot>
    <div class="p-6 space-y-4">
        <a href="{{ route('admin.lunch-options.create') }}" class="admin-btn">Add Lunch Option</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Name</th><th class="p-2"></th></tr></thead>
                <tbody>
                    @foreach($lunchOptions as $option)
                        <tr class="border-t">
                            <td class="p-2">{{ $option->name }}</td>
                            <td class="p-2 text-right">
                                <a href="{{ route('admin.lunch-options.edit', $option) }}" class="text-indigo-600">Edit</a>
                                <form method="POST" action="{{ route('admin.lunch-options.destroy', $option) }}" class="inline" onsubmit="return confirm('Delete this lunch option?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $lunchOptions->links() }}
    </div>
</x-app-layout>

