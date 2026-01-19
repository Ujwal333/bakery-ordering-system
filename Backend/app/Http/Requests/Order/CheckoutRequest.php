<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_window' => 'required|string|in:10AM-1PM,1PM-4PM,4PM-7PM',
            'payment_method' => 'required|string|in:esewa,khalti,cod',
            'transaction_id' => 'required_if:payment_method,esewa,khalti|nullable|string|alpha_num|max:50',
        ];
    }

    public function messages()
    {
        return [
            'delivery_date.after_or_equal' => 'Delivery date cannot be in the past.',
            'payment_method.in' => 'Please select a valid payment method (eSewa, Khalti, or COD).',
        ];
    }
}
