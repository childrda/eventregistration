<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    public function index()
    {
        $eventId = (int) session('admin_event_id');
        $event = Event::query()->findOrFail($eventId);

        $adminUsers = User::query()
            ->where(function ($q) use ($eventId) {
                $q->where('is_super_admin', true)
                    ->orWhereHas('managedEvents', fn ($q2) => $q2->where('events.id', $eventId));
            })
            ->with(['managedEvents' => fn ($q) => $q->where('events.id', $eventId)])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', compact('adminUsers', 'event'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'send_invite' => ['nullable', 'boolean'],
        ]);

        $eventId = (int) session('admin_event_id');

        $existing = User::query()->where('email', $data['email'])->first();

        if ($existing) {
            if ($existing->is_super_admin) {
                return back()->withErrors(['email' => 'This user is already a super admin for all events.']);
            }
            if ($existing->managedEvents()->where('events.id', $eventId)->exists()) {
                return back()->withErrors(['email' => 'This user is already an admin for this event.']);
            }

            $existing->managedEvents()->attach($eventId, ['is_active' => true]);
            if (! $existing->is_admin) {
                $existing->update(['is_admin' => true, 'is_active' => true]);
            }
            $user = $existing;
        } else {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(24)),
                'is_admin' => true,
                'is_active' => true,
            ]);
            $user->managedEvents()->attach($eventId, ['is_active' => true]);
        }

        if ($request->boolean('send_invite')) {
            Password::sendResetLink(['email' => $user->email]);
        }

        return back()->with('success', 'Admin user added for this event.');
    }

    public function update(Request $request, User $user)
    {
        $eventId = (int) session('admin_event_id');

        $allowed = $user->is_super_admin
            || $user->managedEvents()->where('events.id', $eventId)->exists();

        abort_unless($allowed, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'is_active' => ['nullable', 'boolean'],
            'event_access_active' => ['nullable', 'boolean'],
        ]);

        if ($user->is_super_admin) {
            if (! $request->boolean('is_active')) {
                throw ValidationException::withMessages([
                    'is_active' => 'The primary super admin account cannot be disabled.',
                ]);
            }

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            return back()->with('success', 'Admin user updated.');
        }

        $pivotActive = $request->boolean('event_access_active');
        if ($user->managedEvents()->where('events.id', $eventId)->exists()) {
            $user->managedEvents()->updateExistingPivot($eventId, ['is_active' => $pivotActive]);
        }

        $isActive = $request->boolean('is_active');
        if ((int) $request->user()->id === (int) $user->id && ! $isActive) {
            throw ValidationException::withMessages([
                'is_active' => 'You cannot disable your own admin account.',
            ]);
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_active' => $isActive,
        ]);

        return back()->with('success', 'Admin user updated.');
    }
}
