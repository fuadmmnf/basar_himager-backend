<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'client_id' => 'required',
            'type' => 'required| numeric',
            'quantity' => 'required| numeric',
            'cost_per_bag' => 'required| numeric',
            'booking_amount' => 'required| numeric',
            'advance_payment' => 'required| numeric',
            'discount' => 'required| numeric',
            'booking_time' => 'required',
            'selected_year' => 'required',
        ];
    }
}

