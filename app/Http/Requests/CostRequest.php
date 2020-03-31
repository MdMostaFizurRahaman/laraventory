<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostRequest extends FormRequest
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
            'cost_type_id' => 'required',
            'purchase_id' => 'required',
            'description' => 'nullable|string|max:191',
            'amount' => 'required|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'cost_type_id.required' => 'This cost type field is required.',
            'purchase_id.required' => 'This po number field is required.'
        ];
    }
}
