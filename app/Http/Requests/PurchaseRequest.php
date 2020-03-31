<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'supplier_id'   => "required",
            'account_id'    => "required",
            'purchase_date' => "required",
            'receive_date'  => "required",
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'This supplier field is required',
            'account_id.required' => 'This account field is required',
        ];
    }
}
