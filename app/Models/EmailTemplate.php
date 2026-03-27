<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'key',
        'name',
        'subject',
        'html_body',
        'text_body',
        'is_active',
        'from_name',
        'reply_to_email',
        'available_variables',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sentEmails(): HasMany
    {
        return $this->hasMany(SentEmail::class);
    }
}
