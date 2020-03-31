<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BankRequest extends FormRequest
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
                            Rule::unique('banks', 'name'),
                            'max:191'
                        ],
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'  =>
                        [
                            'required',
                            Rule::unique('banks', 'name')->ignore($this->bank->id),
                            'max:191'
                        ],
                    ];
                }
            default:
                break;
        }
    }
}
