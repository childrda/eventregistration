<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Testimonials</h2></x-slot>
    <div class="p-6 space-y-4">
        <a href="{{ route('admin.testimonials.create') }}" class="admin-btn">Add Testimonial</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Person</th><th class="p-2 text-left">Quote</th><th class="p-2"></th></tr></thead>
                <tbody>
                    @foreach($testimonials as $testimonial)
                        <tr class="border-t">
                            <td class="p-2">{{ $testimonial->person_name }}</td>
                            <td class="p-2">{{ $testimonial->quote }}</td>
                            <td class="p-2 text-right">
                                <a class="text-indigo-600" href="{{ route('admin.testimonials.edit', $testimonial) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline" onsubmit="return confirm('Delete this testimonial?')">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-rose-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $testimonials->links() }}
    </div>
</x-app-layout>

