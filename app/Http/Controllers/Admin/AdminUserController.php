<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $adminUsers = User::query()->where('is_admin', true)->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('adminUsers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'send_invite' => ['nullable', 'boolean'],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(Str::random(24)),
            'is_admin' => true,
            'is_active' => true,
        ]);

        if ($request->boolean('send_invite')) {
            Password::sendResetLink(['email' => $user->email]);
        }

        return back()->with('success', 'Admin user added successfully.');
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->is_admin, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'is_active' => ['nullable', 'boolean'],
        ]);

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
