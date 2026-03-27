<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Admin Dashboard</h2></x-slot>
    <div class="p-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="admin-card"><p class="text-xs uppercase tracking-wide text-slate-500">Registrations</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $registrationCount }}</p></div>
        <div class="admin-card"><p class="text-xs uppercase tracking-wide text-slate-500">Speakers</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $speakerCount }}</p></div>
        <div class="admin-card"><p class="text-xs uppercase tracking-wide text-slate-500">Unread Contacts</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $unreadContactCount }}</p></div>
        <div class="admin-card"><p class="text-xs uppercase tracking-wide text-slate-500">Failed Emails</p><p class="mt-2 text-3xl font-bold text-rose-600">{{ $failedEmailCount }}</p></div>
    </div>
</x-app-layout>

