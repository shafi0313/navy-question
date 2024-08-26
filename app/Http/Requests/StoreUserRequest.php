<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'role'              => ['required'],
            'name'              => ['required', 'string', 'min:1', 'max:100'],
            'email'             => ['required', 'string', 'min:1', 'max:64', 'unique:users,email'],
            'mobile'            => ['nullable', 'string', 'min:1', 'max:64'],
            'address'           => ['nullable', 'string', 'min:1', 'max:255'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,jpg,JPG,png,webp,svg', 'max:1024'],
            'password'          => ['required', 'confirmed', 'string', 'min:6'],
        ];
    }
}
