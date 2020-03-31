<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
                            Rule::unique('users', 'name')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'max:191'
                        ],
                        'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'email' =>
                        [
                            'required',
                            Rule::unique('users', 'email')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                            'email'
                        ],
                        'address' => 'required',
                        'password' => 'required|min:6|max:10|confirmed',
                        'role_id' => 'required'
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'  =>
                        [
                            'required',
                            Rule::unique('users', 'name')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->user->id),
                            'max:191'
                        ],
                        'mobile' => 'required|regex:/^(01)[1,5,6,7,8,9]{1}[0-9]{8}$/',
                        'email' =>
                        [
                            'required',
                            Rule::unique('users', 'email')->whereNull('deleted_at')->where('client_id', Auth::user()->client_id)->ignore($this->user->id),
                            'email'
                        ],
                        'address' => 'required',
                        'role_id' => 'required'
                    ];
                }
            default:
                break;
        }
    }
}
