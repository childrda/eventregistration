<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use BelongsToEvent;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'title',
        'subtitle',
        'bio',
        'image_path',
        'external_link',
        'link_label',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        if (str_starts_with($this->image_path, 'uploads/')) {
            return asset($this->image_path);
        }

        return asset('storage/'.$this->image_path);
    }
}
