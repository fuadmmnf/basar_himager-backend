<?php

namespace App\Http\Requests\Inventory\Chamber;

use Illuminate\Foundation\Http\FormRequest;

class CreateChamberEntryRequest extends FormRequest
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
            'chamber_id' => 'required',
            'stage' => 'required',
            'date' => 'required'
        ];
    }
}
