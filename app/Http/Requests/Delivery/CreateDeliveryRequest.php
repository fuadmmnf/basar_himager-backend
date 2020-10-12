<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();

        return $user != null && $user->can('crud:account');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id' => 'required | unique:bookings',
            'delivery_time' => 'required',
            'potatoe_type' => 'required',
            'quantity_bags' => 'equired | numeric',
            'cost_per_bag' => 'required | numeric',
            'quantity_bags_fanned' => ' required | numeric',
            'fancost_per_bag' => 'required | numeric',
            'due_charge' => 'required | numeric',
            'total_charge' => 'required | numeric',
        ];
    }
}
