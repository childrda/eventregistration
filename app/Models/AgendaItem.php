<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaItem extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'start_time',
        'end_time',
        'title',
        'detail_text',
        'document_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function documentUrl(): ?string
    {
        if (! $this->document_path || ! str_starts_with($this->document_path, 'uploads/')) {
            return null;
        }

        return asset($this->document_path);
    }
}
