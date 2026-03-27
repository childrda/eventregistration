@include('admin.partials.form-errors')

@php
    if ($agenda_item) {
        $st = old('start_time', \Illuminate\Support\Carbon::parse($agenda_item->start_time)->format('H:i'));
        $et = old('end_time', \Illuminate\Support\Carbon::parse($agenda_item->end_time)->format('H:i'));
        $so = old('sort_order', $agenda_item->sort_order);
    } else {
        $st = old('start_time', $defaultStartTime ?? '09:00');
        $et = old('end_time', $defaultEndTime ?? \Illuminate\Support\Carbon::createFromFormat('H:i', $st)->addMinutes(30)->format('H:i'));
        $so = old('sort_order', $defaultSortOrder ?? 0);
    }
@endphp

<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-slate-700">Start time</label>
        <input type="time" name="start_time" value="{{ $st }}" class="admin-input mt-1 w-full" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700">End time</label>
        <input type="time" name="end_time" value="{{ $et }}" class="admin-input mt-1 w-full" required>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700">Title (shown on schedule)</label>
    <input type="text" name="title" value="{{ old('title', $agenda_item?->title) }}" class="admin-input mt-1 w-full" required maxlength="255">
</div>

<div>
    <label class="block text-sm font-medium text-slate-700">Sort order (same start time)</label>
    <input type="number" name="sort_order" value="{{ $so }}" class="admin-input mt-1 w-full" min="0">
    @if(! $agenda_item)
        <p class="mt-1 text-xs text-slate-500">Prefilled as the next slot after your last session (by end time). Lower numbers appear first when several items share the same start time.</p>
    @endif
</div>

<div>
    <label class="block text-sm font-medium text-slate-700">More info (optional)</label>
    <textarea name="detail_text" class="admin-input mt-1 w-full font-sans" rows="8" placeholder="Shown on the detail page when attendees click the session.">{{ old('detail_text', $agenda_item?->detail_text) }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium text-slate-700">Document (optional)</label>
    <input type="file" name="document" class="mt-1 w-full text-sm text-slate-600" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
    <p class="mt-1 text-xs text-slate-500">PDF, Word, PowerPoint, or text. Max 15 MB.</p>
    @if($agenda_item?->document_path)
        <p class="mt-2 text-sm text-slate-600">Current file: <code class="rounded bg-slate-100 px-1">{{ basename($agenda_item->document_path) }}</code></p>
        <label class="mt-2 flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="remove_document" value="1" @checked(old('remove_document'))>
            Remove document
        </label>
    @endif
</div>
