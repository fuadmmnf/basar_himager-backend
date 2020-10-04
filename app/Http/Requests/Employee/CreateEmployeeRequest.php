<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => 'required',
            'nid' => 'required| unique:users',
            'name' => 'required',
            'phone' => 'required',
            'designation' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'present_address' => 'required| json',
            'permanent_address' => 'required| json',
            'basic_salary' => 'required| numeric',
            'special_salary' => 'required| numeric',
            'eid_bonus' => 'required| numeric',
        ];
    }
}
