<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Admin Users</h2></x-slot>
    <div class="p-6 space-y-6">
        @if(session('success'))<div class="rounded-lg border border-emerald-300 bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>@endif
        @include('admin.partials.form-errors')

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
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Name</th><th class="p-2 text-left">Email</th><th class="p-2 text-left">Status</th><th class="p-2 text-left">Actions</th></tr></thead>
                <tbody>
                @foreach($adminUsers as $adminUser)
                    <tr class="border-t">
                        <td class="p-2">{{ $adminUser->name }}</td>
                        <td class="p-2">{{ $adminUser->email }}</td>
                        <td class="p-2">{{ $adminUser->is_active ? 'Active' : 'Disabled' }}</td>
                        <td class="p-2">
                            <form method="POST" action="{{ route('admin.users.update', $adminUser) }}" class="flex flex-wrap items-center gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $adminUser->name }}" class="admin-input !w-40">
                                <input type="email" name="email" value="{{ $adminUser->email }}" class="admin-input !w-56">
                                <label class="text-sm"><input type="checkbox" name="is_active" value="1" @checked($adminUser->is_active)> Active</label>
                                <button class="admin-btn">Save</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $adminUsers->links() }}
    </div>
</x-app-layout>

