<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Edit Email Template</h2></x-slot>
    <div class="p-6 space-y-4 max-w-4xl">
        <form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate) }}" class="admin-card space-y-4">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')
            <input class="admin-input" name="name" value="{{ old('name', $emailTemplate->name) }}" placeholder="Template name" />
            <input class="admin-input" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" placeholder="Subject" />
            <textarea class="admin-input font-mono text-sm" name="html_body" rows="10" placeholder="HTML body">{{ old('html_body', $emailTemplate->html_body) }}</textarea>
            <textarea class="admin-input font-mono text-sm" name="text_body" rows="8" placeholder="Text body">{{ old('text_body', $emailTemplate->text_body) }}</textarea>
            <input class="admin-input" name="from_name" value="{{ old('from_name', $emailTemplate->from_name) }}" placeholder="From name" />
            <input class="admin-input" name="reply_to_email" value="{{ old('reply_to_email', $emailTemplate->reply_to_email) }}" placeholder="Reply-to email" />
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $emailTemplate->is_active))> Active</label>
            <button class="admin-btn">Save Template</button>
        </form>
        <div class="admin-card bg-slate-50">
            <h3 class="font-semibold">Available placeholders</h3>
            <pre class="mt-2 whitespace-pre-wrap text-xs">{{ $emailTemplate->available_variables }}</pre>
        </div>
    </div>
</x-app-layout>

