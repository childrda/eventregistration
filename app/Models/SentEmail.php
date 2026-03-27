<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentEmail extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'email_template_id',
        'registration_id',
        'to_email',
        'subject',
        'html_body',
        'text_body',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function emailTemplate(): BelongsTo
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
