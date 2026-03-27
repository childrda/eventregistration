<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Site Settings</h2></x-slot>
    <div class="p-6">
        @if(session('success'))<div class="mb-4 rounded-lg border border-emerald-300 bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('admin.site-settings.update') }}" class="admin-card grid gap-6">
            @csrf @method('PUT')
            @include('admin.partials.form-errors')

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Branding & Event Basics</h3>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Site Name</label>
                        <p class="mb-1 text-xs text-slate-500">Shown in the header/nav brand and browser title.</p>
                        <input name="site_name" value="{{ old('site_name', $siteSetting->site_name) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event Name</label>
                        <p class="mb-1 text-xs text-slate-500">Used throughout homepage and confirmation emails.</p>
                        <input name="event_name" value="{{ old('event_name', $siteSetting->event_name) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event Year</label>
                        <p class="mb-1 text-xs text-slate-500">Used in hero and registration confirmation email subject/body.</p>
                        <input name="event_year" value="{{ old('event_year', $siteSetting->event_year) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Tagline</label>
                        <p class="mb-1 text-xs text-slate-500">Short marketing line for event identity.</p>
                        <input name="tagline" value="{{ old('tagline', $siteSetting->tagline) }}" class="admin-input" />
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Homepage Hero</h3>
                <div class="grid gap-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Hero Heading</label>
                        <p class="mb-1 text-xs text-slate-500">Main headline at top of homepage.</p>
                        <input name="hero_heading" value="{{ old('hero_heading', $siteSetting->hero_heading) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Hero Subheading</label>
                        <p class="mb-1 text-xs text-slate-500">Supporting text under the hero headline.</p>
                        <textarea name="hero_subheading" class="admin-input">{{ old('hero_subheading', $siteSetting->hero_subheading) }}</textarea>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Hero CTA Text</label>
                            <p class="mb-1 text-xs text-slate-500">Button text in the hero section.</p>
                            <input name="hero_cta_text" value="{{ old('hero_cta_text', $siteSetting->hero_cta_text) }}" class="admin-input" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Hero CTA Link</label>
                            <p class="mb-1 text-xs text-slate-500">Where hero CTA button goes (example: /register).</p>
                            <input name="hero_cta_link" value="{{ old('hero_cta_link', $siteSetting->hero_cta_link) }}" class="admin-input" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Registration Settings</h3>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Registration Status</label>
                        <p class="mb-1 text-xs text-slate-500">Controls registration state shown to users.</p>
                        <select name="registration_status" class="admin-input">@foreach(['open','closed','waitlist'] as $status)<option value="{{ $status }}" @selected(old('registration_status', $siteSetting->registration_status)===$status)>{{ ucfirst($status) }}</option>@endforeach</select>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Registration Button Text</label>
                        <p class="mb-1 text-xs text-slate-500">Text for Register buttons in nav/CTA sections.</p>
                        <input name="registration_button_text" value="{{ old('registration_button_text', $siteSetting->registration_button_text) }}" class="admin-input" />
                    </div>
                </div>
                <div class="mt-4">
                    <label class="text-sm font-semibold text-slate-700">Registration Message</label>
                    <p class="mb-1 text-xs text-slate-500">Message shown near the registration form.</p>
                    <textarea name="registration_message" class="admin-input">{{ old('registration_message', $siteSetting->registration_message) }}</textarea>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Agenda & Schedule</h3>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Agenda Button Text</label>
                        <p class="mb-1 text-xs text-slate-500">Text shown on agenda buttons/CTAs.</p>
                        <input name="agenda_button_text" value="{{ old('agenda_button_text', $siteSetting->agenda_button_text) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Agenda URL</label>
                        <p class="mb-1 text-xs text-slate-500">Link opened when users click agenda button.</p>
                        <input name="agenda_url" value="{{ old('agenda_url', $siteSetting->agenda_url) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event Start Time</label>
                        <p class="mb-1 text-xs text-slate-500">Displayed with the event date on the public site.</p>
                        <input type="time" name="event_start_time" value="{{ old('event_start_time', $siteSetting->event_start_time ? \Illuminate\Support\Str::of($siteSetting->event_start_time)->substr(0,5) : '') }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event End Time</label>
                        <p class="mb-1 text-xs text-slate-500">Optional ending time shown with event details.</p>
                        <input type="time" name="event_end_time" value="{{ old('event_end_time', $siteSetting->event_end_time ? \Illuminate\Support\Str::of($siteSetting->event_end_time)->substr(0,5) : '') }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event Start Date</label>
                        <p class="mb-1 text-xs text-slate-500">Shown on homepage and in emails.</p>
                        <input type="date" name="event_start_date" value="{{ old('event_start_date', optional($siteSetting->event_start_date)->format('Y-m-d')) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Event End Date</label>
                        <p class="mb-1 text-xs text-slate-500">Optional end date for multi-day event display.</p>
                        <input type="date" name="event_end_date" value="{{ old('event_end_date', optional($siteSetting->event_end_date)->format('Y-m-d')) }}" class="admin-input" />
                    </div>
                </div>
                <div class="mt-4">
                    <label class="text-sm font-semibold text-slate-700">Agenda HTML Content</label>
                    <p class="mb-1 text-xs text-slate-500">Optional editable agenda page content. If set, the agenda button opens the internal `/agenda` page.</p>
                    <textarea name="agenda_html" class="admin-input font-mono text-sm" rows="12">{{ old('agenda_html', $siteSetting->agenda_html) }}</textarea>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Venue & Contact</h3>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Venue Name</label>
                        <p class="mb-1 text-xs text-slate-500">Shown in “When & Where” areas and emails.</p>
                        <input name="venue_name" value="{{ old('venue_name', $siteSetting->venue_name) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Venue Address Line 1</label>
                        <p class="mb-1 text-xs text-slate-500">Primary street address shown on public site.</p>
                        <input name="venue_address_line_1" value="{{ old('venue_address_line_1', $siteSetting->venue_address_line_1) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Venue Address Line 2</label>
                        <p class="mb-1 text-xs text-slate-500">Optional suite/building/floor line.</p>
                        <input name="venue_address_line_2" value="{{ old('venue_address_line_2', $siteSetting->venue_address_line_2) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">City</label>
                        <p class="mb-1 text-xs text-slate-500">Venue city used in public/event displays.</p>
                        <input name="venue_city" value="{{ old('venue_city', $siteSetting->venue_city) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">State</label>
                        <p class="mb-1 text-xs text-slate-500">Venue state abbreviation or full state.</p>
                        <input name="venue_state" value="{{ old('venue_state', $siteSetting->venue_state) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">ZIP</label>
                        <p class="mb-1 text-xs text-slate-500">Venue ZIP/postal code.</p>
                        <input name="venue_zip" value="{{ old('venue_zip', $siteSetting->venue_zip) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Contact Email</label>
                        <p class="mb-1 text-xs text-slate-500">Shown on contact page and used in email templates.</p>
                        <input name="contact_email" value="{{ old('contact_email', $siteSetting->contact_email) }}" class="admin-input" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Contact Phone</label>
                        <p class="mb-1 text-xs text-slate-500">Optional phone shown on contact page.</p>
                        <input name="contact_phone" value="{{ old('contact_phone', $siteSetting->contact_phone) }}" class="admin-input" />
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 p-4">
                <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Footer</h3>
                <label class="text-sm font-semibold text-slate-700">Footer Text</label>
                <p class="mb-1 text-xs text-slate-500">Shown at bottom of every public page.</p>
                <textarea name="footer_text" class="admin-input">{{ old('footer_text', $siteSetting->footer_text) }}</textarea>
            </div>

            <button class="admin-btn">Save</button>
        </form>
    </div>
</x-app-layout>

