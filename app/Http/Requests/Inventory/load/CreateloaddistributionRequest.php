<?php


namespace App\Http\Requests\Inventory\load;


class CreateloaddistributionRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'booking_id' => 'required',
            'receive_id' => 'required',
            'compartment_id' => 'required',
            'bag_no' => 'required',
            'distributions' => 'required | array',
        ];
    }

}
