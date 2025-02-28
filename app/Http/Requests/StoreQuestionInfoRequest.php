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
            'rank_id' => ['required', 'exists:ranks,id'],
            'exam_name' => ['required', 'string', 'min:1', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['nullable', 'date'],
            'd_hour' => ['nullable', 'string', 'min:1', 'max:8'],
            'd_minute' => ['nullable', 'string', 'min:1', 'max:8'],
            'status' => ['nullable', 'integer', 'min:0', 'max:255'],
            'note' => ['nullable', 'string', 'min:1'],
            'comment' => ['nullable', 'string', 'min:1'],

            'subject_id.*' => ['required', 'exists:subjects,id'],
            'mark.*' => ['required', 'integer'],
        ];
    }
}
