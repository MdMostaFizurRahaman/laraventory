<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CurrencyRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'name'  =>
                        [
                            'required',
                            Rule::unique('currencies', 'name'),
                            'max:191'
                        ],
                        'symbol'  =>
                        [
                            'required',
                            Rule::unique('currencies', 'symbol'),
                            'max:5'
                        ],
                        'ratio' => 'required|numeric|min:1'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'  =>
                        [
                            'required',
                            Rule::unique('currencies', 'name')->ignore($this->currency->id),
                            'max:191'
                        ],
                        'symbol'  =>
                        [
                            'required',
                            Rule::unique('currencies', 'symbol')->ignore($this->currency->id),
                            'max:5'
                        ],
                        'ratio' => 'required|numeric|min:1'
                    ];
                }
            default:
                break;
        }
    }
}
