<?php

namespace App\Http\Requests\Receive;

use Illuminate\Foundation\Http\FormRequest;

class CreateReceiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();

        return $user != null && $user->can('crud:store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id' => 'required',
            'receiving_time' => 'required',
            'quantity' => 'required| numeric',
            'quantity_left' => 'required| numeric',
            'potatoe_type' => 'required',
            'transport' => 'required',
        ];
    }
}
