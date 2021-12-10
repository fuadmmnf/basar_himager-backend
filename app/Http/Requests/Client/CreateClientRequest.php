<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'nid' => 'required',
            'name' => 'required',
            'phone' => 'required| unique:users',
            'father_name' => 'required',
            'mother_name' => 'required',
            'address' => 'required',
            'year' => 'required'
        ];
    }
}
