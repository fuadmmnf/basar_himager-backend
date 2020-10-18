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
            'booking_id' => 'required | unique:bookings',
            'delivery_time' => 'required',
//        $table->integer('potatoe_type');
//        $table->integer('quantity_bags');
//        $table->double('cost_per_bag');
//        $table->integer('quantity_bags_fanned')->default(0);
//        $table->double('fancost_per_bag')->default(0);
//        $table->double('due_charge');
//        $table->double('total_charge');
//        $table->timestamps();
        ];
    }
}
