<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'district_name',
        'first_name',
        'last_name',
        'email',
        'title_role',
        'total_rooms_reserved',
        'tshirt_size_id',
        'food_allergies',
        'lunch_option_id',
        'status',
        'confirmation_token',
        'notes',
    ];

    public function tshirtSize(): BelongsTo
    {
        return $this->belongsTo(TshirtSize::class);
    }

    public function lunchOption(): BelongsTo
    {
        return $this->belongsTo(LunchOption::class);
    }

    public function sentEmails(): HasMany
    {
        return $this->hasMany(SentEmail::class);
    }
}
