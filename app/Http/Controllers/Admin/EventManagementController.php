<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaItem;
use App\Models\ContentSection;
use App\Models\EmailTemplate;
use App\Models\Event;
use App\Models\Faq;
use App\Models\LunchOption;
use App\Models\Page;
use App\Models\Testimonial;
use App\Models\TshirtSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventManagementController extends Controller
{
    public function index()
    {
        $events = Event::query()->orderBy('sort_order')->orderBy('id')->paginate(25);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $sourceEvents = Event::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.events.create', compact('sourceEvents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:events,slug'],
            'event_name' => ['required', 'string', 'max:255'],
            'copy_from_event_id' => ['nullable', 'integer', 'exists:events,id'],
        ]);

        $sourceId = $data['copy_from_event_id'] ?? (int) session('admin_event_id');
        $source = Event::query()->findOrFail($sourceId);

        DB::transaction(function () use ($source, $data) {
            $new = $source->replicate();
            $new->slug = $data['slug'];
            $new->event_name = $data['event_name'];
            $new->site_name = $data['event_name'];
            $new->is_enabled = true;
            $new->save();

            $newId = $new->id;
            $sourceId = $source->id;

            foreach (Page::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (EmailTemplate::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (ContentSection::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (LunchOption::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (TshirtSize::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (Faq::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (Testimonial::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->save();
            }
            foreach (AgendaItem::query()->where('event_id', $sourceId)->get() as $row) {
                $copy = $row->replicate();
                $copy->event_id = $newId;
                $copy->document_path = null;
                $copy->save();
            }
        });

        return redirect()->route('admin.events.index')->with('success', 'Event created. Switch to it from the sidebar to edit details.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('events', 'slug')->ignore($event->id)],
            'is_enabled' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
        ]);

        $event->update([
            'slug' => $data['slug'],
            'is_enabled' => $request->boolean('is_enabled'),
            'sort_order' => $data['sort_order'] ?? $event->sort_order,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }
}
