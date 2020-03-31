<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiveRequest extends FormRequest
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
            'receive_date' => 'required',
            'note' => 'max:191',
        ];

        foreach($this->request->get('receive_quantity') as $key => $val)
        {
          $rules['receive_quantity.'.$key] = 'required|numeric|min:0|max:'.$this->request->get('max_quantity')[$key];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'receive_quantity.*.required' => 'This receive quantity field is required.',
            'receive_quantity.*.numeric' => 'This receive quantity field must be numeric.',
            'receive_quantity.*.min' => 'This receive quantity field should at least 0.',
            'receive_quantity.*.max' => 'The receive quantity may not be greater than :max.',
        ];
    }
}
