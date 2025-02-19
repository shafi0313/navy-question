<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'subject_id' => ['required', 'exists:subjects,id'],
            'type' => ['required', 'string', 'in:multiple_choice'],
            'ques' => ['required', 'string', 'min:1'],
            'mark' => ['required', 'integer', 'min:1', 'max:10'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,JPG,png,webp,svg'],

            
            'option' => 'required|array',
            'correct' => 'required|array|in:yes,no',
        ];
    }
}
