<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use App\Models\Event;

class AgendaController extends Controller
{
    public function index()
    {
        $settings = $this->publicEventSettings();
        $eventId = (int) session('public_event_id');

        $items = AgendaItem::query()
            ->where('event_id', $eventId)
            ->orderBy('start_time')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($items->isNotEmpty()) {
            $rows = $items
                ->groupBy(fn (AgendaItem $item) => $item->start_time->format('H:i'))
                ->sortKeys();

            return view('public.agenda-schedule', [
                'settings' => $settings,
                'rows' => $rows,
            ]);
        }

        abort_if(blank($settings->agenda_html) && blank($settings->agenda_url), 404);

        return view('public.agenda', compact('settings'));
    }

    public function show(AgendaItem $agenda_item)
    {
        $settings = $this->publicEventSettings();

        return view('public.agenda-show', [
            'settings' => $settings,
            'item' => $agenda_item,
        ]);
    }

    protected function publicEventSettings(): Event
    {
        $eventId = (int) session('public_event_id');

        return Event::query()->enabled()->whereKey($eventId)->firstOrFail();
    }
}
