<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'role'    => ['required', 'exists:roles,name'],
            'name'    => ['required', 'string', 'min:1', 'max:100'],
            'email'   => ['required', 'string', 'email', 'max:64', 'unique:users,email,' . $this->user->id,],
            'mobile'  => ['nullable', 'string', 'min:10', 'max:64'],
            'address' => ['nullable', 'string', 'min:1', 'max:255'],
            'image'   => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,svg', 'max:1024'],
        ];
    }
}
