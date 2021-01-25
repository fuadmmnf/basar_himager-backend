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
            'receiving_time' => 'required',
            'receives' => 'required| array',
//              items in receives
//            'booking_id' => 'required',
//            'receiveitems' => 'required| array',
//            'transport' => 'required',
        ];
    }
}
