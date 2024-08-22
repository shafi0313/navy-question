<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionInfoRequest extends FormRequest
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
            'exam_id'  => ['required', 'exists:exams,id'],
            'rank_id'  => ['required', 'exists:ranks,id'],
            'date'     => ['required', 'date'],
            'time'     => ['nullable'],
            'd_hour'   => ['nullable', 'integer', 'min:0', 'max:127'],
            'd_minute' => ['nullable', 'integer', 'min:0', 'max:127'],
            'status'   => ['nullable', 'string', 'in:Pending,Created,Started,Completed'],
            'note'     => ['nullable', 'string', 'min:1']
        ];
    }
}
