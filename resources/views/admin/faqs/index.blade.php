<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">FAQs</h2></x-slot>
    <div class="p-6 space-y-4">
        <a href="{{ route('admin.faqs.create') }}" class="admin-btn">Add FAQ</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Question</th><th class="p-2"></th></tr></thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr class="border-t">
                            <td class="p-2">{{ $faq->question }}</td>
                            <td class="p-2 text-right">
                                <a class="text-indigo-600" href="{{ route('admin.faqs.edit', $faq) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete this FAQ?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $faqs->links() }}
    </div>
</x-app-layout>

