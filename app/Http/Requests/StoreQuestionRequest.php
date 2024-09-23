<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'subject_id' => ['required', 'exists:subjects,id'],
            'rank_id' => ['required', 'exists:ranks,id'],
            'type' => ['required', 'string', 'in:multiple_choice'],
            // 'type'       => ['required', 'string', 'in:multiple_choice,short_question,long_question'],
            'ques' => ['required', 'string', 'min:1'],
            'mark' => ['required', 'integer', 'min:0', 'max:2147483647'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,JPG,png,webp,svg'],

            'option.*' => ['required', 'string', 'min:1', 'max:255'],
            'correct' => ['nullable', 'boolean'],
        ];
    }
}
