<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'is_enabled',
        'sort_order',
        'site_name',
        'event_name',
        'event_year',
        'tagline',
        'hero_heading',
        'hero_subheading',
        'hero_cta_text',
        'hero_cta_link',
        'registration_status',
        'registration_message',
        'venue_name',
        'venue_address_line_1',
        'venue_address_line_2',
        'venue_city',
        'venue_state',
        'venue_zip',
        'event_start_date',
        'event_start_time',
        'event_end_date',
        'event_end_time',
        'contact_email',
        'contact_phone',
        'agenda_url',
        'agenda_html',
        'agenda_button_text',
        'registration_button_text',
        'footer_text',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'event_start_date' => 'date',
        'event_end_date' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('is_active')->withTimestamps();
    }

    public function agendaItems(): HasMany
    {
        return $this->hasMany(AgendaItem::class);
    }

    public function hasAgendaContent(): bool
    {
        return $this->agendaItems()->exists()
            || filled($this->agenda_html)
            || filled($this->agenda_url);
    }
}
