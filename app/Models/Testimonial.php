<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'quote',
        'person_name',
        'person_title',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
