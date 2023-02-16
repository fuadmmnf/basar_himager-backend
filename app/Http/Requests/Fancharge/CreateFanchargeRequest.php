<?php

namespace App\Http\Requests\Fancharge;

use Illuminate\Foundation\Http\FormRequest;

class CreateFanchargeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->guard('api')->user();

        return $user != null && $user->can('crud:account');    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fanneditems' => 'required|array',
        ];
    }
}
