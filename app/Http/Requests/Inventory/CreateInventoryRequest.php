<?php


namespace App\Http\Requests\Inventory;


class CreateInventoryRequest extends \Illuminate\Foundation\Http\FormRequest
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
            'parent_id' => 'sometimes',
            'category' => 'required',
            'name' => 'required',
            'capacity' => 'required | numeric',
            'remaining_capacity' => 'required | numeric',
        ];
    }

}
