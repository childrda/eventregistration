<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    public function managedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withPivot('is_active')->withTimestamps();
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }

    public function accessibleAdminEvents(): Collection
    {
        if ($this->isSuperAdmin()) {
            return Event::query()->orderBy('sort_order')->orderBy('id')->get();
        }

        return $this->managedEvents()
            ->wherePivot('is_active', true)
            ->orderBy('events.sort_order')
            ->orderBy('events.id')
            ->get();
    }

    public function canManageEvent(int $eventId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->managedEvents()
            ->where('events.id', $eventId)
            ->wherePivot('is_active', true)
            ->exists();
    }

    public function pivotActiveForEvent(int $eventId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $pivot = $this->managedEvents()->where('events.id', $eventId)->first()?->pivot;

        return $pivot && (bool) $pivot->is_active;
    }
}
