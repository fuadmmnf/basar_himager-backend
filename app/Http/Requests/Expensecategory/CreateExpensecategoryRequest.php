<?php

namespace App\Http\Requests\Expensecategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpensecategoryRequest extends FormRequest
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
            'type' => 'required',
            'category' => 'required',
        ];
    }
}
