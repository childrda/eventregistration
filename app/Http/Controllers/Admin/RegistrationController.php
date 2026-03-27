<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateRegistrationRequest;
use App\Http\Controllers\Controller;
use App\Models\LunchOption;
use App\Models\Registration;
use App\Models\TshirtSize;
use App\Services\TemplateEmailService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Registration::query()->with(['lunchOption', 'tshirtSize'])->latest();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('district_name', 'like', "%{$search}%");
            });
        }

        if ($district = request('district')) {
            $query->where('district_name', $district);
        }
        if ($lunch = request('lunch_option_id')) {
            $query->where('lunch_option_id', $lunch);
        }
        if ($shirt = request('tshirt_size_id')) {
            $query->where('tshirt_size_id', $shirt);
        }

        return view('admin.registrations.index', [
            'registrations' => $query->paginate(25)->withQueryString(),
            'districts' => Registration::query()->select('district_name')->distinct()->orderBy('district_name')->pluck('district_name'),
            'lunchOptions' => LunchOption::query()->orderBy('sort_order')->get(),
            'tshirtSizes' => TshirtSize::query()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        $registration->load(['lunchOption', 'tshirtSize', 'sentEmails']);
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $registration->update($request->validated());
        return redirect()->route('admin.registrations.show', $registration)->with('success', 'Registration updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration) {}

    public function exportCsv(): StreamedResponse
    {
        $filename = 'registrations_'.now()->format('Ymd_His').'.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename={$filename}"];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['District', 'First Name', 'Last Name', 'Email', 'Role', 'Rooms', 'Shirt', 'Allergies', 'Lunch', 'Status', 'Created']);

            Registration::query()->with(['tshirtSize', 'lunchOption'])->orderBy('created_at')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->district_name,
                        $row->first_name,
                        $row->last_name,
                        $row->email,
                        $row->title_role,
                        $row->total_rooms_reserved,
                        optional($row->tshirtSize)->name,
                        $row->food_allergies,
                        optional($row->lunchOption)->name,
                        $row->status,
                        $row->created_at,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, $headers);
    }

    public function resendConfirmation(Registration $registration, TemplateEmailService $templateEmailService)
    {
        $templateEmailService->sendRegistrationConfirmation($registration->load('tshirtSize', 'lunchOption'));
        return back()->with('success', 'Confirmation email resend attempted. Check email log for status.');
    }
}
