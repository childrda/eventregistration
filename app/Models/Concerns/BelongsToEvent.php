<?php

namespace App\Models\Concerns;

use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToEvent
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeForAdminEvent($query, ?int $eventId = null)
    {
        $id = $eventId ?? (int) session('admin_event_id');

        return $query->where('event_id', $id);
    }
}
