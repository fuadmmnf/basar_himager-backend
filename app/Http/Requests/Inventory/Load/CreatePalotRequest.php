<?php

namespace App\Http\Requests\Inventory\Load;

use Illuminate\Foundation\Http\FormRequest;

class CreatePalotRequest extends FormRequest
{
    public function rules()
    {
        return [
            'receive_id' => 'required |numeric',
            'loaddistributions' => 'required | array',
            'palot_status' => 'required|in:load,first,second,third,fourth"'
        ];
    }

    public function authorize()
    {
        $user = auth()->guard('api')->user();
        return $user != null && $user->can('crud:store');
    }
}
