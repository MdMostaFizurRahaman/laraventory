<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseBillRequest extends FormRequest
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
        $rules = [
            'bill_date' => 'required|date',
            'due_date' => 'required|date',
            'currency_id' => 'required',
            'reference' => 'nullable|string|max:191',
            'note' => 'nullable|string|max:191',
        ];

        foreach($this->request->get('bill_quantity') as $key => $val)
        {
          $rules['bill_quantity.'.$key] = 'required|numeric|min:0|max:'.$this->request->get('max_quantity')[$key];
        }

        foreach($this->request->get('rate') as $key => $val)
        {
          $rules['rate.'.$key] = 'required|numeric|min:0';
        }

        // foreach($this->request->get('total') as $key => $val)
        // {
        //   $rules['total.'.$key] = 'required|numeric|min:0';
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'bill_quantity.*.required' => 'This bill quantity field is required.',
            'bill_quantity.*.numeric' => 'This bill quantity field must be numeric.',
            'bill_quantity.*.min' => 'This bill quantity field should at least 0.',
            'bill_quantity.*.max' => 'The bill quantity may not be greater than :max.',

            'rate.*.required' => 'This rate field is required.',
            'rate.*.numeric' => 'This rate field must be numeric.',
            'rate.*.min' => 'This rate field should at least 0.',

            // 'total.*.required' => 'This total field is required.',
            // 'total.*.numeric' => 'This total field must be numeric.',
            // 'total.*.min' => 'This total field should at least 0.',

        ];
    }
}
