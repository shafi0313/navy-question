<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuesInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'exists:exams,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'set' => ['sometimes', 'integer', 'min:-128', 'max:127'],
            'date' => ['required', 'date'],
            'time' => ['nullable'],
            'd_hour' => ['required', 'integer', 'min:-128', 'max:127'],
            'd_minute' => ['required', 'integer', 'min:-128', 'max:127'],
            'mode' => ['required', 'string', 'min:1', 'max:191'],
            'trade' => ['nullable', 'string', 'min:1', 'max:191'],
            'status' => ['nullable', 'string', 'in:Pending,Created,Started,Completed'],
            'note' => ['nullable', 'string', 'min:1', 'max:255'],
            'option_note' => ['nullable', 'string', 'min:1', 'max:255'],
        ];
    }
}
