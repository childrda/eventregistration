<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateAgendaItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'title' => ['required', 'string', 'max:255'],
            'detail_text' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'document' => ['nullable', 'file', 'max:15360', 'mimes:pdf,doc,docx,ppt,pptx,txt'],
            'remove_document' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $start = $this->input('start_time');
            $end = $this->input('end_time');
            if ($start && $end && strtotime($end) <= strtotime($start)) {
                $validator->errors()->add('end_time', 'End time must be after start time.');
            }
        });
    }
}
