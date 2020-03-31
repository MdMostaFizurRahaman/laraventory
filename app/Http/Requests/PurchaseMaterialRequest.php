<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseMaterialRequest extends FormRequest
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
            'material_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'rate' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1',
        ];
    }


    public function messages()
    {
        return [
            'material_id.required' => 'This material field is required',
        ];
    }
}
