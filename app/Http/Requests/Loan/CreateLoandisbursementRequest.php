<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class CreateLoandisbursementRequest extends FormRequest
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
            'booking_id'=> 'required | unique:bookings',
            'amount'=> 'required | numeric',
            'amount_left'=> 'required | numeric',
            'payment_date' => 'required',
        ];
    }
}
