<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
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
