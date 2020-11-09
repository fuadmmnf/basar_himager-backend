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
        $user = auth()->guard('api')->user();

        return $user != null && $this->has('role') && $user->can('crud:' . $this->role);
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
            'nid' => 'required',
            'name' => 'required',
            'phone' => 'required| unique:users',
            'designation' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'basic_salary' => 'required| numeric',
            'special_salary' => 'required| numeric',
        ];
    }
}
