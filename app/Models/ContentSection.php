<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'section_key',
        'title',
        'subtitle',
        'body',
        'button_text',
        'button_url',
        'is_enabled',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
}
