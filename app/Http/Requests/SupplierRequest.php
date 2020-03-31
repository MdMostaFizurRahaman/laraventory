<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
                            Rule::unique('suppliers', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'max:191'
                        ],
                        'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'email' =>
                        [
                            Rule::unique('suppliers', 'email')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'email'
                        ],
                        'address' => 'required|max:191',
                        'opening_balance' => 'sometimes|nullable|numeric|min:0',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'  =>
                        [
                            'required',
                            Rule::unique('suppliers', 'name')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->supplier->id),
                            'max:191'
                        ],
                        'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'email' =>
                        [
                            Rule::unique('suppliers', 'email')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->supplier->id),
                            'email'
                        ],
                        'address' => 'required|max:191',
                        'opening_balance' => 'sometimes|nullable|numeric|min:0',
                    ];
                }
            default:
                break;
        }
    }
}
