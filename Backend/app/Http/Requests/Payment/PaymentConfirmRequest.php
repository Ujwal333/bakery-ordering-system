<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentConfirmRequest extends FormRequest
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
            'payment_method' => 'required|string|in:esewa,khalti,cod',
            'transaction_id' => 'required_if:payment_method,esewa,khalti|nullable|string|alpha_num|unique:payments,transaction_id',
        ];
    }

    public function messages()
    {
        return [
            'transaction_id.required_if' => 'Transaction ID is required for digital payments.',
            'transaction_id.unique' => 'This transaction ID has already been used.',
        ];
    }
}
