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
//            'amount' => 'required| numeric',
            'loan_payment' => 'required| numeric',
            'bonus' => 'required| numeric',
            'remark' => 'required',
            'salary_month' => 'required',
            'payment_time' => 'required',
            'working_day' => 'required',
        ];
    }
}
