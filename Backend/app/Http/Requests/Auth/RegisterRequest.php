<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|regex:/^[a-zA-Z\s]+$/',
            'email' => ['nullable', 'required_without:phone', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'phone' => ['nullable', 'required_without:email', 'string', 'digits:10', 'regex:/^9[78]\d{8}$/', 'unique:users,phone'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Full Name should only contain letters and spaces.',
            'phone.regex' => 'Mobile number must start with 98 or 97 and be exactly 10 digits.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'phone.unique' => 'This mobile number is already registered.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}
