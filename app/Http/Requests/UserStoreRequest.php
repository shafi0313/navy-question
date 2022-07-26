<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return user()->can('user-add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email',' unique:users','email'],
            'phone' => ['required'],
            'address' => ['required', 'string'],
            'd_o_b' => ['required', 'date'],
            'image' => ['nullable', 'image',' mimes:jpeg,png,jpg,svg', 'max:2048'],
            'password' => ['required', 'confirmed', Password::min(6)
                                                            // ->letters()
                                                            // ->mixedCase()
                                                            // ->numbers()
                                                            // ->symbols()
                                                            // ->uncompromised()
                                                        ],
        ];
    }
}
