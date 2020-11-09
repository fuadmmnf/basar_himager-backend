<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class CreateLoancollectionRequest extends FormRequest
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
            'loandisbursement_id' => 'required | numeric',
            'surcharge' => 'required | numeric',
            'payment_amount' => 'required | numeric',
            'pending_loan_amount' => 'required | numeric',
            'payment_date' => 'required',
        ];
    }
}
