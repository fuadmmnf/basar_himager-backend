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
            'delivery_time' => 'required',
            'deliveries' => 'required|array',
            'selected_year' => 'required',
//            items in deliveries
//            'booking_id' => 'required | numeric',
////            'potato_type' => 'required',
////            'quantity_bags' => 'required| numeric',
//            'deliveryitems' => 'required| array',
//            'cost_per_bag' => 'required| numeric',
//            'quantity_bags_fanned' => 'required| numeric',
//            'fancost_per_bag' => 'required| numeric',
//            'do_charge' => 'required| numeric',
        ];
    }
}
