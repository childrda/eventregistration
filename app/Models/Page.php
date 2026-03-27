<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'slug',
        'title',
        'intro',
        'body',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
