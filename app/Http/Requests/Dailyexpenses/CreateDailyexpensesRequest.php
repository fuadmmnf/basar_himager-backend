<?php

namespace App\Http\Requests\Dailyexpenses;

use Illuminate\Foundation\Http\FormRequest;

class CreateDailyexpensesRequest extends FormRequest
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
            'expensecategory_id' => 'required | numeric',
            'voucher_no' => 'required',
            'date' => 'required',
            'amount' => 'required | numeric',
        ];
    }
}
