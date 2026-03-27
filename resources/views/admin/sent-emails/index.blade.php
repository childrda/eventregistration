<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Sent Email Log</h2></x-slot>
    <div class="p-6 space-y-4">
        <form method="GET" class="admin-card grid gap-3 md:grid-cols-4">
            <select name="email_template_id" class="admin-input">
                <option value="">All templates</option>
                @foreach($templates as $template)<option value="{{ $template->id }}" @selected((string)request('email_template_id')===(string)$template->id)>{{ $template->name }}</option>@endforeach
            </select>
            <input name="to_email" value="{{ request('to_email') }}" placeholder="Filter email" class="admin-input" />
            <select name="status" class="admin-input">
                <option value="">Any status</option>
                @foreach(['sent','failed'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ ucfirst($status) }}</option>@endforeach
            </select>
            <button class="admin-btn">Filter</button>
        </form>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">To</th><th class="p-2 text-left">Template</th><th class="p-2 text-left">Status</th><th class="p-2 text-left">Sent</th><th class="p-2"></th></tr></thead>
                <tbody>
                @foreach($sentEmails as $email)
                    <tr class="border-t">
                        <td class="p-2">{{ $email->to_email }}</td>
                        <td class="p-2">{{ optional($email->emailTemplate)->name }}</td>
                        <td class="p-2">{{ $email->status }}</td>
                        <td class="p-2">{{ $email->sent_at }}</td>
                        <td class="p-2 text-right"><a href="{{ route('admin.sent-emails.show', $email) }}" class="text-indigo-600">Open</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $sentEmails->links() }}
    </div>
</x-app-layout>

