<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'district_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', Rule::unique('registrations', 'email')],
            'title_role' => ['required', 'string', 'max:255'],
            'total_rooms_reserved' => ['nullable', 'integer', 'min:0'],
            'tshirt_size_id' => ['nullable', 'exists:tshirt_sizes,id'],
            'food_allergies' => ['nullable', 'string'],
            'lunch_option_id' => ['nullable', 'exists:lunch_options,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email address has already been used to register for this event.',
        ];
    }
}
