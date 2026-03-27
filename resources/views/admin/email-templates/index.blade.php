<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Email Templates</h2></x-slot>
    <div class="p-6">
        <div class="overflow-x-auto rounded border">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Name</th><th class="p-2 text-left">Key</th><th class="p-2 text-left">Active</th><th class="p-2"></th></tr></thead>
                <tbody>
                @foreach($emailTemplates as $template)
                    <tr class="border-t">
                        <td class="p-2">{{ $template->name }}</td>
                        <td class="p-2">{{ $template->key }}</td>
                        <td class="p-2">{{ $template->is_active ? 'Yes' : 'No' }}</td>
                        <td class="p-2 text-right"><a class="text-indigo-600" href="{{ route('admin.email-templates.edit', $template) }}">Edit</a> | <a class="text-indigo-600" href="{{ route('admin.email-templates.show', $template) }}">Preview</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $emailTemplates->links() }}</div>
    </div>
</x-app-layout>

