<?php


namespace App\Http\Requests\Inventory\Unloading;


class CreateUnloadingRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'delivery_id' => 'required',
            'unloadings' => 'required | array',
        ];
    }

}
