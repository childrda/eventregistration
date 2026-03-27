<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Registrations</h2></x-slot>
    <div class="p-6 space-y-4">
        <form method="GET" class="admin-card grid gap-3 md:grid-cols-5">
            <input class="admin-input" name="search" value="{{ request('search') }}" placeholder="Search" />
            <select class="admin-input" name="district">
                <option value="">All districts</option>
                @foreach($districts as $district)<option value="{{ $district }}" @selected(request('district')===$district)>{{ $district }}</option>@endforeach
            </select>
            <select class="admin-input" name="lunch_option_id">
                <option value="">All lunch options</option>
                @foreach($lunchOptions as $option)<option value="{{ $option->id }}" @selected((string)request('lunch_option_id')===(string)$option->id)>{{ $option->name }}</option>@endforeach
            </select>
            <select class="admin-input" name="tshirt_size_id">
                <option value="">All shirt sizes</option>
                @foreach($tshirtSizes as $size)<option value="{{ $size->id }}" @selected((string)request('tshirt_size_id')===(string)$size->id)>{{ $size->name }}</option>@endforeach
            </select>
            <button class="admin-btn">Filter</button>
        </form>
        <a href="{{ route('admin.registrations.export') }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Export CSV</a>
        <div class="admin-card overflow-x-auto p-0">
            <table class="admin-table">
                <thead class="bg-gray-100"><tr><th class="p-2 text-left">Name</th><th class="p-2 text-left">Email</th><th class="p-2 text-left">District</th><th class="p-2 text-left">Status</th><th class="p-2"></th></tr></thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr class="border-t">
                        <td class="p-2">{{ $registration->first_name }} {{ $registration->last_name }}</td>
                        <td class="p-2">{{ $registration->email }}</td>
                        <td class="p-2">{{ $registration->district_name }}</td>
                        <td class="p-2">{{ $registration->status }}</td>
                        <td class="p-2 text-right"><a class="text-indigo-600" href="{{ route('admin.registrations.show', $registration) }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $registrations->links() }}
    </div>
</x-app-layout>

