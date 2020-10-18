<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeSalaryRequest extends FormRequest
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
            'employee_id' => 'required| numeric',
            'basic_salary' => 'required| numeric',
            'special_salary' => 'required| numeric',
            'eid_bonus' => 'required| numeric',
            'payment_time' => 'required',
        ];
    }
}
