<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();

        return $user != null &&  $user->can('crud:account');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nid' => 'required| unique:users',
            'name' => 'required',
            'father_name' => 'required',
            'address' => 'required',
            'type' => 'required| numeric',
            'quantity' => 'required| numeric',
            'advance_payment' => 'required| numeric',
            'discount' => 'required| numeric',
            'booking_time' => 'required',
        ];
    }
}

