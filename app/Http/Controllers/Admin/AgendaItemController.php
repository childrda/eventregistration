<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgendaItemRequest;
use App\Http\Requests\Admin\UpdateAgendaItemRequest;
use App\Models\AgendaItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AgendaItemController extends Controller
{
    public function index()
    {
        $items = AgendaItem::query()
            ->forAdminEvent()
            ->orderBy('start_time')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(40);

        return view('admin.agenda-items.index', compact('items'));
    }

    public function create()
    {
        $eventId = (int) session('admin_event_id');

        $last = AgendaItem::query()
            ->where('event_id', $eventId)
            ->orderByDesc('end_time')
            ->orderByDesc('start_time')
            ->orderByDesc('id')
            ->first();

        $defaultStartTime = $last
            ? Carbon::parse($last->end_time)->format('H:i')
            : '09:00';

        $defaultEndTime = Carbon::createFromFormat('H:i', $defaultStartTime)->addMinutes(30)->format('H:i');

        $maxSort = AgendaItem::query()->where('event_id', $eventId)->max('sort_order');
        $defaultSortOrder = $maxSort === null ? 0 : (int) $maxSort + 1;

        return view('admin.agenda-items.create', compact(
            'defaultStartTime',
            'defaultEndTime',
            'defaultSortOrder'
        ));
    }

    public function store(StoreAgendaItemRequest $request)
    {
        $data = collect($request->validated())->except(['document'])->all();
        $eventId = (int) session('admin_event_id');

        if ($request->hasFile('document')) {
            $data['document_path'] = $this->storeDocument($request->file('document'), $eventId);
        }

        AgendaItem::query()->create([
            ...$data,
            'event_id' => $eventId,
        ]);

        return redirect()->route('admin.agenda-items.index')->with('success', 'Agenda item created.');
    }

    public function edit(AgendaItem $agenda_item)
    {
        return view('admin.agenda-items.edit', compact('agenda_item'));
    }

    public function update(UpdateAgendaItemRequest $request, AgendaItem $agenda_item)
    {
        $data = collect($request->validated())->except(['document', 'remove_document'])->all();
        $eventId = (int) session('admin_event_id');

        if ($request->boolean('remove_document')) {
            $this->deleteDocument($agenda_item->document_path);
            $data['document_path'] = null;
        }

        if ($request->hasFile('document')) {
            $this->deleteDocument($agenda_item->document_path);
            $data['document_path'] = $this->storeDocument($request->file('document'), $eventId);
        }

        $agenda_item->update($data);

        return redirect()->route('admin.agenda-items.index')->with('success', 'Agenda item updated.');
    }

    public function destroy(AgendaItem $agenda_item)
    {
        $this->deleteDocument($agenda_item->document_path);
        $agenda_item->delete();

        return redirect()->route('admin.agenda-items.index')->with('success', 'Agenda item removed.');
    }

    protected function storeDocument($file, int $eventId): string
    {
        $dir = public_path('uploads/agenda/'.$eventId);
        File::ensureDirectoryExists($dir);

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = substr($filename, 0, 80).'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'uploads/agenda/'.$eventId.'/'.$filename;
    }

    protected function deleteDocument(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'uploads/')) {
            return;
        }

        File::delete(public_path($path));
    }
}
