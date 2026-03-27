<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'event_start_date' => 'date',
        'event_end_date' => 'date',
    ];
}
