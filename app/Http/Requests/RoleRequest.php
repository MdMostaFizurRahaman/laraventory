<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                        'display_name'  => [
                            'required',
                            Rule::unique('roles')->where('user_id', Auth::user()->client_id)->where('type', 'client'),
                            'max:191'
                        ],
                        'description'  => 'required',
                        'permissions'  => 'required',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'display_name'  => [
                            'required',
                            Rule::unique('roles')->where('client_id', Auth::user()->client_id)->where('type', 'client')->ignore($this->role->id,'id'),
                            'max:191'
                        ],
                        'description'  => 'required',
                        'permissions'  => 'required',
                    ];
                }
            default:
                break;
        }
    }
}
