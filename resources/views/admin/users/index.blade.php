<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Admin Users — {{ $event->event_name }}</h2></x-slot>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="rounded-lg border border-emerald-300 bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>@endif
        @include('admin.partials.form-errors')

        <p class="text-sm text-slate-600">Invitations grant access only for <strong>{{ $event->event_name }}</strong>. Super admins can manage every event.</p>

        <form method="POST" action="{{ route('admin.users.store') }}" class="admin-card grid gap-3 md:grid-cols-3">
            @csrf
            <input name="name" class="admin-input" placeholder="Admin name" value="{{ old('name') }}">
            <input name="email" class="admin-input" placeholder="Admin email" value="{{ old('email') }}">
            <div class="flex items-center gap-3">
                <label class="text-sm"><input type="checkbox" name="send_invite" value="1" checked> Send invite email</label>
                <button class="admin-btn">Invite Admin</button>
            </div>
        </form>

        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Name</th><th class="p-2 text-left">Email</th><th class="p-2 text-left">Role</th><th class="p-2 text-left">Account</th><th class="p-2 text-left">This event</th><th class="p-2 text-left">Actions</th></tr></thead>
                <tbody>
                @foreach($adminUsers as $adminUser)
                    <tr class="border-t">
                        <td class="p-2">{{ $adminUser->name }}</td>
                        <td class="p-2">{{ $adminUser->email }}</td>
                        <td class="p-2">
                            @if($adminUser->is_super_admin)
                                <span class="rounded bg-violet-100 px-2 py-0.5 text-xs font-semibold text-violet-900">Super admin (all events)</span>
                            @else
                                <span class="text-slate-600">Event admin</span>
                            @endif
                        </td>
                        <td class="p-2">
                            @if($adminUser->is_super_admin)
                                <span class="text-emerald-700">Always active</span>
                            @else
                                {{ $adminUser->is_active ? 'Active' : 'Disabled' }}
                            @endif
                        </td>
                        <td class="p-2">
                            @if($adminUser->is_super_admin)
                                <span class="text-slate-500">—</span>
                            @else
                                @php $pivot = $adminUser->managedEvents->first()?->pivot; @endphp
                                {{ $pivot && $pivot->is_active ? 'Active' : 'Revoked' }}
                            @endif
                        </td>
                        <td class="p-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <form method="POST" action="{{ route('admin.users.update', $adminUser) }}" class="flex flex-wrap items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $adminUser->name }}" class="admin-input !w-40">
                                    <input type="email" name="email" value="{{ $adminUser->email }}" class="admin-input !w-56">
                                    @if($adminUser->is_super_admin)
                                        <input type="hidden" name="is_active" value="1">
                                    @else
                                        <label class="text-sm"><input type="checkbox" name="is_active" value="1" @checked($adminUser->is_active)> Account active</label>
                                        <label class="text-sm"><input type="checkbox" name="event_access_active" value="1" @checked(optional($adminUser->managedEvents->first()?->pivot)->is_active ?? false)> Access this event</label>
                                    @endif
                                    <button class="admin-btn">Save</button>
                                </form>
                                @if(! $adminUser->is_super_admin)
                                    <form method="POST" action="{{ route('admin.users.remove-from-event', $adminUser) }}" class="inline" onsubmit="return confirm(@js('Remove this person from admins for '.$event->event_name.'? Their account stays; they only lose access to this event.'));">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded border border-red-200 bg-white px-2 py-1 text-sm text-red-700 hover:bg-red-50">Remove from event</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $adminUsers->links() }}
    </div>
</x-app-layout>
