<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'province' => 'required|string|in:Koshi,Madhesh,Bagmati,Gandaki,Lumbini,Karnali,Sudurpashchim',
            'district' => 'required|string',
            'city' => 'required|string|in:Kathmandu,Lalitpur,Bhaktapur',
            'area' => 'required|string|min:3',
            'street' => 'required|string',
            'latitude' => 'required|numeric|between:27.5,27.8', // Approx Kathmandu bounds
            'longitude' => 'required|numeric|between:85.2,85.5',
        ];
    }

    public function messages()
    {
        return [
            'city.in' => 'We currently only deliver within the Kathmandu Valley (Kathmandu, Lalitpur, Bhaktapur).',
            'latitude.between' => 'The selected location must be within the Kathmandu Valley delivery range.',
        ];
    }
}
