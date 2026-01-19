<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'login_identifier' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'login_identifier.required' => 'Please enter your email address or mobile number.',
            'password.required' => 'Password is required to log in.',
        ];
    }
}
