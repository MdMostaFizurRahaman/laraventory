<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
                        'account_name'  =>
                        [
                            'required',
                            Rule::unique('accounts', 'account_name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'max:191'
                        ],
                        'account_number' =>
                        [
                            Rule::unique('accounts', 'account_number')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'max:191'
                        ],
                        'account_mobile_number' => 'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'opening_balance' => 'required|numeric|min:0',
                        'branch_name' => 'max:191',
                        'branch_code' => 'max:191',
                        'bank_id' => 'max:191',
                        'status' => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'account_name'  =>
                        [
                            'required',
                            Rule::unique('accounts', 'account_name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($this->account->id),
                            'max:191'
                        ],
                        'account_number' =>
                        [
                            Rule::unique('accounts', 'account_number')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($this->account->id),
                            'max:191'
                        ],
                        'account_mobile_number' => 'regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'branch_name' => 'max:191',
                        'branch_code' => 'max:191',
                        'bank_id' => 'max:191',
                        'status' => 'required',
                        'opening_balance' => 'required|numeric|min:0',
                    ];
                }
            default:
                break;
        }
    }
}
