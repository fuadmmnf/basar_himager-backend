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

        return $user != null && $this->has('role') && (
                ($this->role == 'admin' && $user->hasRole('super_admin')) ||
                ($this->role == 'manager:admin' && $user->hasAnyRole(['super_admin', 'admin'])) ||
                ($this->role == 'manager:account' || $this->role == 'manager:store' &&
                    $user->hasAnyRole(['super_admin', 'admin', 'manager:admin'])) ||
                ($this->role == 'worker')
            );
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
