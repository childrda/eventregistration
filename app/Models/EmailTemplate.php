<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
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
